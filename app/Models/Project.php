<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'category',
        'status',
        'image',
        'author',
        'user_id',
        'date',
        'published_at',
        'is_pinned',
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
            'user_id' => 'integer',
            'published_at' => 'date',
            'is_pinned' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Project $project) {
            if (empty($project->slug)) {
                $project->slug = static::generateUniqueSlug($project->title);
            }
        });

        static::updating(function (Project $project) {
            if (empty($project->slug) && $project->isDirty('title')) {
                $project->slug = static::generateUniqueSlug($project->title, $project->id);
            }
        });

        static::deleting(function (Project $project) {
            foreach ($project->projectImages as $img) {
                $galleryImg = $img->getRawOriginal('image');
                if ($galleryImg && ! str_starts_with($galleryImg, 'http')) {
                    Storage::disk('public')->delete($galleryImg);
                }
                $img->delete();
            }

            $mainImg = $project->getRawOriginal('image');
            if ($mainImg && ! str_starts_with($mainImg, 'http')) {
                Storage::disk('public')->delete($mainImg);
            }
        });
    }

    public static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'project-'.time();
        $slug = $base;
        $counter = 1;

        while (static::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $counter++;
            $slug = "{$base}-{$counter}";
        }

        return $slug;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? 'slug', $value)
            ->orWhere('id', $value)
            ->firstOrFail();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function projectImages(): HasMany
    {
        return $this->hasMany(ProjectImage::class);
    }

    public function getImageAttribute(?string $value): ?string
    {
        if (! $value) {
            return null;
        }

        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://') || str_starts_with($value, '//')) {
            return $value;
        }

        $path = ltrim($value, '/');
        if (str_ends_with(strtolower($path), '.webp')) {
            $path = preg_replace('/\.webp$/i', '.jpg', $path);
        }

        return asset('storage/'.$path);
    }
}
