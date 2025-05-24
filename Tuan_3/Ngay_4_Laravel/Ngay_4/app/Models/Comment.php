<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'commentable_id',
        'commentable_type',
        'user_id',
        'content',
    ];

    // Quan hệ morph tới Course hoặc Lesson
    public function commentable()
    {
        return $this->morphTo();
    }

    // Quan hệ với User (người viết comment)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
