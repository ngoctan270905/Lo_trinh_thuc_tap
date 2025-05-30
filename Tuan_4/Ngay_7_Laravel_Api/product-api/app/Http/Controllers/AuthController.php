<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Đăng nhập
    public function login(Request $request)
    {
        // Validate dữ liệu đầu vào
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Kiểm tra thông tin đăng nhập
        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['Thông tin đăng nhập không đúng.'],
            ]);
        }

        $user = Auth::user();

        // Xóa hết các token cũ (nếu muốn, hoặc giữ lại nếu muốn đăng nhập nhiều thiết bị)
        $user->tokens()->delete();

        // Tạo token mới
        $token = $user->createToken('api-token')->plainTextToken;

        // Trả về thông tin user và token
        return response()->json([
            'message' => 'Đăng nhập thành công',
            'user' => $user,
            'token' => $token,
        ]);
    }

    // Đăng xuất
    public function logout(Request $request)
    {
        // Xóa token hiện tại (token đang dùng để gọi api logout)
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Đăng xuất thành công',
        ]);
    }

    // Lấy user hiện tại
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
