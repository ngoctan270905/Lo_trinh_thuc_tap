<?php
class QuanLyCongTacVien {
    private array $danhSachCTV = [];

    public function themCTV(CongTacVien $ctv): void {
        $this->danhSachCTV[] = $ctv;
    }

    public function hienThiDanhSach(): void {
        foreach ($this->danhSachCTV as $ctv) {
            echo $ctv->thongTinTongQuan() . "<br>";
        }
    }

    public function tongHoaHong(float $giaTriDon): float {
        $tong = 0;
        foreach ($this->danhSachCTV as $ctv) {
            $tong += $ctv->tinhHoaHong($giaTriDon);
        }
        return $tong;
    }
}
