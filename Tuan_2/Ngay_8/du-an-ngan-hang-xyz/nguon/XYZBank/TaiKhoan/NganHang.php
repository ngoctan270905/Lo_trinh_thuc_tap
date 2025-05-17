<?php
namespace XYZBank\TaiKhoan;

class NganHang
{
    private static int $tongSoTaiKhoan = 0;

    public static function tangSoLuongTaiKhoan(): void
    {
        self::$tongSoTaiKhoan++;
    }

    public static function layTongSoTaiKhoan(): int
    {
        return self::$tongSoTaiKhoan;
    }

    public static function tenNganHang(): string
    {
        return "Ngân hàng XYZ";
    }
}
