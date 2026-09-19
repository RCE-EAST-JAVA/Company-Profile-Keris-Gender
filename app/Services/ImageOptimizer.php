<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ImageOptimizer
{
    /**
     * Optimize an uploaded image, resize if necessary, and store as JPG or PNG (WebP is strictly forbidden).
     */
    public function optimizeAndStore(
        UploadedFile $file,
        string $directory,
        int $maxWidth = 1920,
        int $quality = 85
    ): string {
        $extension = strtolower($file->getClientOriginalExtension());
        $mime = strtolower((string) $file->getMimeType());

        // 1. Strictly disallow WebP
        if ($extension === 'webp' || $mime === 'image/webp') {
            throw ValidationException::withMessages([
                'image' => 'Format WebP tidak diizinkan. Harap gunakan format JPG atau PNG.',
            ]);
        }

        // 2. If vector SVG, store directly
        if ($extension === 'svg' || $mime === 'image/svg+xml') {
            return $file->store($directory, 'public');
        }

        // 3. Read image into GD resource
        $realPath = $file->getRealPath();
        $source = null;

        try {
            $contents = file_get_contents($realPath);
            if ($contents !== false) {
                $source = @imagecreatefromstring($contents);
            }
        } catch (\Throwable) {
            $source = null;
        }

        // If GD cannot process the image, fallback to standard store
        if (! $source) {
            return $file->store($directory, 'public');
        }

        // 4. Fix EXIF orientation for JPEG
        if (function_exists('exif_read_data') && ($extension === 'jpg' || $extension === 'jpeg')) {
            try {
                $exif = @exif_read_data($realPath);
                if (! empty($exif['Orientation'])) {
                    $source = match ($exif['Orientation']) {
                        3 => imagerotate($source, 180, 0),
                        6 => imagerotate($source, -90, 0),
                        8 => imagerotate($source, 90, 0),
                        default => $source,
                    };
                }
            } catch (\Throwable) {
                // Continue with current orientation
            }
        }

        $width = imagesx($source);
        $height = imagesy($source);

        $isPng = ($extension === 'png' || $mime === 'image/png');

        // 5. Resize proportionally if width exceeds $maxWidth
        if ($width > $maxWidth && $maxWidth > 0) {
            $newWidth = $maxWidth;
            $newHeight = (int) round(($height / $width) * $newWidth);

            $target = imagecreatetruecolor($newWidth, $newHeight);

            if ($isPng) {
                imagealphablending($target, false);
                imagesavealpha($target, true);
                $transparent = imagecolorallocatealpha($target, 255, 255, 255, 127);
                imagefilledrectangle($target, 0, 0, $newWidth, $newHeight, $transparent);
            }

            imagecopyresampled($target, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($source);
            $source = $target;
        } else {
            if ($isPng) {
                imagealphablending($source, false);
                imagesavealpha($source, true);
            }
        }

        // 6. Save as PNG or JPG (No WebP)
        $targetExt = $isPng ? 'png' : 'jpg';
        $filename = Str::random(40).'.'.$targetExt;
        $relativeDir = trim($directory, '/');
        Storage::disk('public')->makeDirectory($relativeDir);

        $fullPath = Storage::disk('public')->path("{$relativeDir}/{$filename}");

        if ($isPng) {
            // PNG compression level 6 (0-9)
            $saved = @imagepng($source, $fullPath, 6);
        } else {
            $saved = @imagejpeg($source, $fullPath, $quality);
        }

        imagedestroy($source);

        if (! $saved || ! file_exists($fullPath)) {
            return $file->store($directory, 'public');
        }

        return "{$relativeDir}/{$filename}";
    }

    /**
     * Delete an old stored file if it exists and is not an external URL.
     */
    public function deleteOld(?string $rawPath): void
    {
        if (! $rawPath) {
            return;
        }

        if (str_starts_with($rawPath, 'http://') || str_starts_with($rawPath, 'https://') || str_starts_with($rawPath, '//')) {
            return;
        }

        Storage::disk('public')->delete($rawPath);
    }
}
