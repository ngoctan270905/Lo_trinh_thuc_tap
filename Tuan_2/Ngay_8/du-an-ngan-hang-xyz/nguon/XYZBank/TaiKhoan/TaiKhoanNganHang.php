<?php
namespace XYZBank\TaiKhoan;

abstract class TaiKhoanNganHang
{
    protected string $soTaiKhoan;
    protected string $tenChuTaiKhoan;
    protected float $soDu;

    public function __construct(string $soTaiKhoan, string $tenChuTaiKhoan, float $soDu)
    {
        $this->soTaiKhoan = $soTaiKhoan;
        $this->tenChuTaiKhoan = $tenChuTaiKhoan;
        $this->soDu = $soDu;

        // Mỗi lần tạo tài khoản, tăng tổng số tài khoản của hệ thống
        NganHang::tangSoLuongTaiKhoan();
    }

    public function laySoDu(): float
    {
        return $this->soDu;
    }

    public function layTenChuTaiKhoan(): string
    {
        return $this->tenChuTaiKhoan;
    }

    public function laySoTaiKhoan(): string
    {
        return $this->soTaiKhoan;
    }

    abstract public function guiTien(float $soTien): void;

    abstract public function rutTien(float $soTien): void;

    abstract public function loaiTaiKhoan(): string;
}
