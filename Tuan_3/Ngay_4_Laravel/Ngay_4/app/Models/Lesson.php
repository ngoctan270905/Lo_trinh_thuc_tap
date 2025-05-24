<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'content',
        // thêm các cột khác nếu cần
    ];

    // Quan hệ ngược n-1 với Course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Quan hệ n-n với Tag qua bảng trung gian lesson_tag
    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    // Quan hệ morphMany với Comment
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
