<?php
class CongTacVien {
    const TEN_NEN_TANG = "VietLink Affiliate";

    protected string $hoTen;
    protected string $email;
    protected float $tiLeHoaHong;
    protected bool $dangHoatDong;

    public function __construct(string $hoTen, string $email, float $tiLeHoaHong, bool $dangHoatDong = true) {
        $this->hoTen = $hoTen;
        $this->email = $email;
        $this->tiLeHoaHong = $tiLeHoaHong;
        $this->dangHoatDong = $dangHoatDong;
    }

    public function __destruct() {
        echo "⛔ Cộng tác viên '{$this->hoTen}' đã bị hủy khỏi bộ nhớ.<br>";
    }

    public function tinhHoaHong(float $giaTriDonHang): float {
        return $giaTriDonHang * $this->tiLeHoaHong / 100;
    }

    public function thongTinTongQuan(): string {
        return "🌟 {$this->hoTen} ({$this->email}) - Hoa hồng: {$this->tiLeHoaHong}% - Nền tảng: " . self::TEN_NEN_TANG;
    }
}
