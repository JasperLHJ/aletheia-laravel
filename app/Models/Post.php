<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'body',
        'excerpt',
        'featured_image',
        'reading_time_minutes',
        'is_featured',
        'category',
        'published_at',
        'status',
        'user_id',
        'source',
        'external_id',
        'source_url',
        'video_url',
        'media_type',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'published_at' => 'datetime',
            'reading_time_minutes' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function metaDescription(int $length = 160): string
    {
        $source = $this->excerpt ?: (string) $this->body;

        $clean = trim(preg_replace('/\s+/', ' ', strip_tags($source)) ?? '');

        if (mb_strlen($clean) <= $length) {
            return $clean;
        }

        return rtrim(mb_substr($clean, 0, $length - 1)).'…';
    }

    /**
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }
}
