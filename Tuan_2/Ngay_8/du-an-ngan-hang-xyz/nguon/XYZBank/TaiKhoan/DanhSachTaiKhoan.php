<?php
namespace XYZBank\TaiKhoan;

use IteratorAggregate;
use ArrayIterator;


class DanhSachTaiKhoan implements IteratorAggregate
{
    private array $danhSach = [];

    public function themTaiKhoan(TaiKhoanNganHang $taiKhoan): void
    {
        $this->danhSach[] = $taiKhoan;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->danhSach);
    }

    /**
     * @return TaiKhoanNganHang[]
     */
    public function locTaiKhoanLon(): array
    {
        return array_filter($this->danhSach, function ($taiKhoan) {
            return $taiKhoan->laySoDu() >= 10000000;
        });
    }

    /**
     * @param string $soTaiKhoan
     * @return TaiKhoanNganHang|null
     */
    public function timTaiKhoan(string $soTaiKhoan): ?TaiKhoanNganHang
    {
        foreach ($this->danhSach as $taiKhoan) {
            if ($taiKhoan->laySoTaiKhoan() === $soTaiKhoan) {
                return $taiKhoan;
            }
        }
        return null;
    }
}
