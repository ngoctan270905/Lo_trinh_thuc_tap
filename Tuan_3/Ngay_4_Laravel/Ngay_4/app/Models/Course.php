<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        // thêm các cột khác nếu cần
    ];

    // Quan hệ ngược n-1 với User (giảng viên)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ 1-n với Lesson
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    // Quan hệ morphMany với Comment
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
