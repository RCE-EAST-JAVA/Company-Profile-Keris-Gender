<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Staff extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'role',
        'category',
        'expertise',
        'description',
        'image',
        'email',
        'linkedin',
        'sort_order',
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
            'sort_order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Staff $staff) {
            if (empty($staff->slug)) {
                $staff->slug = static::generateUniqueSlug($staff->name);
            }
        });

        static::updating(function (Staff $staff) {
            if (empty($staff->slug) && $staff->isDirty('name')) {
                $staff->slug = static::generateUniqueSlug($staff->name, $staff->id);
            }
        });
    }

    public static function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $cleanName = trim(preg_replace('/,\s*.*$/', '', $name));
        $cleanName = trim(preg_replace('/^(Prof\.|Dr\.|Dra\.|Drs\.|dr\.)\s*/i', '', $cleanName));
        $baseSlug = Str::slug($cleanName ?: $name) ?: 'staff-'.time();
        $slug = $baseSlug;
        $counter = 1;

        while (static::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $counter++;
            $slug = "{$baseSlug}-{$counter}";
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
}
