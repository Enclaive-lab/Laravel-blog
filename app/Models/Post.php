<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['title', 'image', 'slug', 'excerpt', 'body', 'is_published', 'published_at', 'user_id'];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        $forgetCache = function (Post $post): void {
            $id = $post->getKey();

            DB::afterCommit(function () use ($id): void {
                Cache::forget('posts_all');
                Cache::forget('posts_trash');
                Cache::forget("post_{$id}");
            });
        };

        static::saved($forgetCache);
        static::deleted($forgetCache);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(related: User::class, foreignKey: 'user_id');
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}
