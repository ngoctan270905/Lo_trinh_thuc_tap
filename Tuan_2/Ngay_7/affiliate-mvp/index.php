<?php
require_once 'CongTacVien.php';
require_once 'CongTacVienCaoCap.php';
require_once 'QuanLyCongTacVien.php';

$quanLy = new QuanLyCongTacVien();

$ctv1 = new CongTacVien("Nguyễn Văn A", "a@email.com", 5);
$ctv2 = new CongTacVien("Trần Thị B", "b@email.com", 8);
$ctv3 = new CongTacVienCaoCap("Phạm Văn C", "c@email.com", 6, 50000);

$quanLy->themCTV($ctv1);
$quanLy->themCTV($ctv2);
$quanLy->themCTV($ctv3);

echo "<h2>📋 Danh sách cộng tác viên</h2>";
$quanLy->hienThiDanhSach();

$donHang = 2000000;

echo "<h2>💵 Hoa hồng cho mỗi CTV với đơn hàng $donHang VNĐ</h2>";
echo "{$ctv1->thongTinTongQuan()} - Hoa hồng: " . number_format($ctv1->tinhHoaHong($donHang)) . " VNĐ<br>";
echo "{$ctv2->thongTinTongQuan()} - Hoa hồng: " . number_format($ctv2->tinhHoaHong($donHang)) . " VNĐ<br>";
echo "{$ctv3->thongTinTongQuan()} - Hoa hồng: " . number_format($ctv3->tinhHoaHong($donHang)) . " VNĐ<br>";

echo "<h2>💰 Tổng hoa hồng cần chi:</h2>";
echo number_format($quanLy->tongHoaHong($donHang)) . " VNĐ";
