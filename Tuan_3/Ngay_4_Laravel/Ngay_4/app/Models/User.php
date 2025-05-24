<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // nếu bạn thêm cột role phân biệt giảng viên, học viên
    ];

    // Quan hệ 1-1 với Profile
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    // Quan hệ 1-n với Course (giảng viên)
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    // Quan hệ 1-n với Comment (người dùng viết bình luận)
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
