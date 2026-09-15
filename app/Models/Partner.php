<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'logo',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
        ];
    }

    public function getLogoAttribute(?string $value): ?string
    {
        if (! $value) {
            return null;
        }

        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://') || str_starts_with($value, '//')) {
            return $value;
        }

        $lower = strtolower($value);
        if (str_ends_with($lower, '.svg') || str_ends_with($lower, '.png') || str_ends_with($lower, '.jpg') || str_ends_with($lower, '.jpeg') || str_ends_with($lower, '.webp')) {
            return asset('storage/'.ltrim($value, '/'));
        }

        return $value;
    }

    public function isImageLogo(): bool
    {
        if (! $this->logo) {
            return false;
        }

        $lower = strtolower($this->logo);

        return str_starts_with($lower, 'http://')
            || str_starts_with($lower, 'https://')
            || str_contains($lower, '/storage/')
            || str_ends_with($lower, '.svg')
            || str_ends_with($lower, '.png')
            || str_ends_with($lower, '.jpg')
            || str_ends_with($lower, '.jpeg')
            || str_ends_with($lower, '.webp');
    }
}
