<?php
namespace XYZBank\TaiKhoan;

trait GhiNhatKyGiaoDich
{
    public function ghiLogGiaoDich(string $loai, float $soTien, float $soDuMoi): void
    {
        $thoiGian = date('Y-m-d H:i:s');
        echo "[{$thoiGian}] Giao dịch: {$loai} " . number_format($soTien, 0, ',', '.') . " VNĐ | Số dư mới: " . number_format($soDuMoi, 0, ',', '.') . " VNĐ\n";
    }
}
