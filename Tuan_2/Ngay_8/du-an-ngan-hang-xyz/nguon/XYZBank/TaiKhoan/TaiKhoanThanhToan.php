<?php
namespace XYZBank\TaiKhoan;


class TaiKhoanThanhToan extends TaiKhoanNganHang
{
    use GhiNhatKyGiaoDich;

    public function guiTien(float $soTien): void
    {
        $this->soDu += $soTien;
        $this->ghiLogGiaoDich("Gửi tiền", $soTien, $this->soDu);
    }

    public function rutTien(float $soTien): void
    {
        if ($soTien <= $this->soDu) {
            $this->soDu -= $soTien;
            $this->ghiLogGiaoDich("Rút tiền", $soTien, $this->soDu);
        } else {
            echo "Không thể rút. Số dư không đủ.\n";
        }
    }

    public function loaiTaiKhoan(): string
    {
        return "Thanh toán";
    }
}
