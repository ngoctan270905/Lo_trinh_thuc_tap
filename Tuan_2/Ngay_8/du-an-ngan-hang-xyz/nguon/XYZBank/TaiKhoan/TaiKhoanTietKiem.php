<?php
namespace XYZBank\TaiKhoan;

class TaiKhoanTietKiem extends TaiKhoanNganHang implements CoLaiSuat
{
    use GhiNhatKyGiaoDich;

    private const LAI_SUAT = 0.05;

    public function guiTien(float $soTien): void
    {
        $this->soDu += $soTien;
        $this->ghiLogGiaoDich("Gửi tiền", $soTien, $this->soDu);
    }

    public function rutTien(float $soTien): void
    {
        if (($this->soDu - $soTien) >= 1000000) {
            $this->soDu -= $soTien;
            $this->ghiLogGiaoDich("Rút tiền", $soTien, $this->soDu);
        } else {
            echo "Không thể rút. Số dư sau rút phải ≥ 1.000.000 VNĐ.\n";
        }
    }

    public function tinhLaiSuatNam(): float
    {
        return $this->soDu * self::LAI_SUAT;
    }

    public function loaiTaiKhoan(): string
    {
        return "Tiết kiệm";
    }
}
