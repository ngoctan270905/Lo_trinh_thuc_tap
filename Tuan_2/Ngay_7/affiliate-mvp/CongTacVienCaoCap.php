<?php
require_once 'CongTacVien.php';

class CongTacVienCaoCap extends CongTacVien {
    protected int $thuongMoiDon;

    public function __construct(string $hoTen, string $email, float $tiLeHoaHong, int $thuongMoiDon, bool $dangHoatDong = true) {
        parent::__construct($hoTen, $email, $tiLeHoaHong, $dangHoatDong);
        $this->thuongMoiDon = $thuongMoiDon;
    }

    public function tinhHoaHong(float $giaTriDonHang): float {
        return parent::tinhHoaHong($giaTriDonHang) + $this->thuongMoiDon;
    }
}
