<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'content', 'status', 'published_at', 'author_id'];

    public function author(): BelongsTo {
        return $this->belongsTo(Author::class);
    }

    public function scopePublished($query) {
        return $query->where('status', 'published');
    }

    public function scopeRecent($query) {
        return $query->where('created_at', '>=', now()->subDays(30));
    }

    public function setTitleAttribute($value) {
        $this->attributes['title'] = ucwords($value);
        $this->attributes['slug'] = Str::slug($value);
    }

    public function getPublishedAtAttribute($value) {
        return $value ? \Carbon\Carbon::parse($value)->format('d/m/Y H:i') : null;
    }
}

