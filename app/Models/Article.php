<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'cover_image',
        'published_at',
    ];

    public function developers(): BelongsToMany
    {
        return $this->belongsToMany(Developer::class);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(static function ($article) {
            $article->slug = Str::slug($article->title);
        });
    }
}
