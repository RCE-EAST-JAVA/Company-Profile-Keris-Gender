<?php

namespace Database\Seeders\Concerns;

use Illuminate\Support\Facades\Storage;

trait GeneratesPlaceholderImages
{
    /**
     * Ensure a placeholder SVG image exists in storage/app/public.
     */
    protected function ensurePlaceholderImage(
        string $path,
        string $title,
        string $subtitle = '',
        string $bgColor = '#be123c',
        string $secondaryColor = '#881337',
        int $width = 640,
        int $height = 420
    ): string {
        $disk = Storage::disk('public');

        if (! $disk->exists($path)) {
            $escapedTitle = htmlspecialchars($title, ENT_XML1, 'UTF-8');
            $escapedSubtitle = htmlspecialchars($subtitle, ENT_XML1, 'UTF-8');

            $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="{$width}" height="{$height}" viewBox="0 0 {$width} {$height}">
  <defs>
    <linearGradient id="grad_{$width}_{$height}" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="{$bgColor}" />
      <stop offset="100%" stop-color="{$secondaryColor}" />
    </linearGradient>
  </defs>
  <rect width="100%" height="100%" fill="url(#grad_{$width}_{$height})" rx="8" />
  <g fill="#ffffff" opacity="0.12">
    <circle cx="85%" cy="18%" r="110" />
    <circle cx="12%" cy="82%" r="80" />
  </g>
  <text x="50%" y="45%" dominant-baseline="middle" text-anchor="middle" font-family="Arial, sans-serif" font-weight="bold" font-size="20" fill="#ffffff">
    {$escapedTitle}
  </text>
  <text x="50%" y="58%" dominant-baseline="middle" text-anchor="middle" font-family="Arial, sans-serif" font-size="13" fill="#ffe4e6" letter-spacing="1">
    {$escapedSubtitle}
  </text>
</svg>
SVG;

            $disk->put($path, $svg);
        }

        return $path;
    }
}
