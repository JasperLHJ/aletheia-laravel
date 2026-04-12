<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'quote',
        'author',
        'role',
        'initials',
        'status',
        'is_featured',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Testimonial $testimonial) {
            if ($testimonial->initials === null || $testimonial->initials === '') {
                $testimonial->initials = self::initialsFromAuthor($testimonial->author);
            }
        });
    }

    public static function initialsFromAuthor(string $author): string
    {
        $clean = preg_replace('/[^a-zA-Z0-9\s]/', ' ', $author);
        $words = array_values(array_filter(preg_split('/\s+/', trim((string) $clean)) ?: []));

        if (count($words) === 0) {
            return '??';
        }

        if (count($words) === 1) {
            return strtoupper(mb_substr($words[0], 0, 2));
        }

        return strtoupper(mb_substr($words[0], 0, 1).mb_substr($words[1], 0, 1));
    }

    /**
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    /**
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /**
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }
}
