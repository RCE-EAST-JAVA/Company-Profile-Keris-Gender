<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageOptimizer
{
    /**
     * Optimize an uploaded image, resize if necessary, convert to WebP, and store in the specified public directory.
     */
    public function optimizeAndStore(
        UploadedFile $file,
        string $directory,
        int $maxWidth = 1920,
        int $quality = 85
    ): string {
        $extension = strtolower($file->getClientOriginalExtension());
        $mime = $file->getMimeType();

        // 1. If vector SVG, store directly without raster conversion
        if ($extension === 'svg' || $mime === 'image/svg+xml') {
            return $file->store($directory, 'public');
        }

        // 2. Read image into GD resource
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

        // If GD cannot process the image, fallback to standard Laravel store
        if (! $source) {
            return $file->store($directory, 'public');
        }

        // 3. Fix EXIF orientation if JPEG
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
                // Continue with original orientation if EXIF read fails
            }
        }

        $width = imagesx($source);
        $height = imagesy($source);

        // 4. Resize proportionally if width exceeds $maxWidth
        if ($width > $maxWidth && $maxWidth > 0) {
            $newWidth = $maxWidth;
            $newHeight = (int) round(($height / $width) * $newWidth);

            $target = imagecreatetruecolor($newWidth, $newHeight);

            // Handle transparency for PNG / WebP
            imagealphablending($target, false);
            imagesavealpha($target, true);
            $transparent = imagecolorallocatealpha($target, 255, 255, 255, 127);
            imagefilledrectangle($target, 0, 0, $newWidth, $newHeight, $transparent);

            imagecopyresampled($target, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($source);
            $source = $target;
        } else {
            // Preserve alpha channel if not resized
            imagealphablending($source, false);
            imagesavealpha($source, true);
        }

        // 5. Save as WebP
        $filename = Str::random(40).'.webp';
        $relativeDir = trim($directory, '/');
        Storage::disk('public')->makeDirectory($relativeDir);

        $fullPath = Storage::disk('public')->path("{$relativeDir}/{$filename}");

        $saved = @imagewebp($source, $fullPath, $quality);
        imagedestroy($source);

        if (! $saved || ! file_exists($fullPath)) {
            // Fallback if imagewebp failed
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
