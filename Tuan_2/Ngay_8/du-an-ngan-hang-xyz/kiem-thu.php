<?php

spl_autoload_register(function ($class) {
    $file = __DIR__ . '/nguon/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    } else {
        echo "<p style='color:red;'>Không tìm thấy file: $file</p>";
    }
});

require_once __DIR__ . '/nguon/XYZBank/TaiKhoan/TaiKhoanNganHang.php';
require_once __DIR__ . '/nguon/XYZBank/TaiKhoan/CoLaiSuat.php';
require_once __DIR__ . '/nguon/XYZBank/TaiKhoan/GhiNhatKyGiaoDich.php';
require_once __DIR__ . '/nguon/XYZBank/TaiKhoan/TaiKhoanTietKiem.php';
require_once __DIR__ . '/nguon/XYZBank/TaiKhoan/TaiKhoanThanhToan.php';
require_once __DIR__ . '/nguon/XYZBank/TaiKhoan/NganHang.php';
require_once __DIR__ . '/nguon/XYZBank/TaiKhoan/DanhSachTaiKhoan.php';

use XYZBank\TaiKhoan\TaiKhoanTietKiem;
use XYZBank\TaiKhoan\TaiKhoanThanhToan;
use XYZBank\TaiKhoan\DanhSachTaiKhoan;
use XYZBank\TaiKhoan\NganHang;

session_start();

if (!isset($_SESSION['ds'])) {
    $ds = new DanhSachTaiKhoan();
    $ds->themTaiKhoan(new TaiKhoanTietKiem("10201122", "Nguyễn Thị A", 20000000));
    $ds->themTaiKhoan(new TaiKhoanThanhToan("20301123", "Lê Văn B", 8000000));
    $ds->themTaiKhoan(new TaiKhoanThanhToan("20401124", "Trần Minh C", 12000000));
    $_SESSION['ds'] = serialize($ds);
}

$ds = unserialize($_SESSION['ds']);
if (!$ds instanceof DanhSachTaiKhoan) {
    $ds = new DanhSachTaiKhoan();
    $ds->themTaiKhoan(new TaiKhoanTietKiem("10201122", "Nguyễn Thị A", 20000000));
    $ds->themTaiKhoan(new TaiKhoanThanhToan("20301123", "Lê Văn B", 8000000));
    $ds->themTaiKhoan(new TaiKhoanThanhToan("20401124", "Trần Minh C", 12000000));
    $_SESSION['ds'] = serialize($ds);
}

$thongBao = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $soTaiKhoan = $_POST['soTaiKhoan'] ?? '';
    $loai = $_POST['loai'] ?? '';
    $soTien = floatval($_POST['soTien'] ?? 0);

    // Validation
    if ($soTien <= 0) {
        $thongBao = "Số tiền phải lớn hơn 0";
    } else {
        $taiKhoan = $ds->timTaiKhoan($soTaiKhoan);
        if ($taiKhoan === null) {
            $thongBao = "Không tìm thấy tài khoản";
        } else {
            try {
                if ($loai === 'gui') {
                    $taiKhoan->guiTien($soTien);
                    $thongBao = "Đã gửi " . number_format($soTien, 0, ',', '.') . " VNĐ vào tài khoản " . $taiKhoan->laySoTaiKhoan();
                } elseif ($loai === 'rut') {
                    $taiKhoan->rutTien($soTien);
                    $thongBao = "Đã rút " . number_format($soTien, 0, ',', '.') . " VNĐ từ tài khoản " . $taiKhoan->laySoTaiKhoan();
                }
                $_SESSION['ds'] = serialize($ds);
            } catch (Exception $e) {
                $thongBao = "Lỗi: " . $e->getMessage();
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Ngân hàng XYZ - Kiểm thử</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
  <h1 class="mb-4">🔐 Hệ thống quản lý tài khoản - Ngân hàng XYZ</h1>

  <?php if ($thongBao): ?>
    <div class="alert alert-info"><?= $thongBao ?></div>
  <?php endif; ?>

  <div class="card mb-4">
    <div class="card-header">🔁 Thực hiện giao dịch</div>
    <div class="card-body">
      <form method="post">
        <div class="row g-3">
          <div class="col-md-4">
            <label class="form-label">Chọn tài khoản</label>
            <select name="soTaiKhoan" class="form-select" required>
              <?php foreach ($ds as $tk): ?>
                <option value="<?= $tk->laySoTaiKhoan() ?>">
                  <?= $tk->laySoTaiKhoan() ?> - <?= $tk->layTenChuTaiKhoan() ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label">Loại giao dịch</label>
            <select name="loai" class="form-select">
              <option value="gui">Gửi tiền</option>
              <option value="rut">Rút tiền</option>
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label">Số tiền (VNĐ)</label>
            <input type="number" name="soTien" class="form-control" min="1000" required>
          </div>
        </div>
        <div class="mt-3">
          <button class="btn btn-primary" type="submit">Thực hiện</button>
        </div>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="card-header">📄 Danh sách tài khoản</div>
    <div class="card-body">
      <table class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>Mã số</th>
          <th>Chủ tài khoản</th>
          <th>Loại tài khoản</th>
          <th>Số dư</th>
          <th>Lãi suất năm</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($ds as $tk): ?>
          <tr>
            <td><?= $tk->laySoTaiKhoan() ?></td>
            <td><?= $tk->layTenChuTaiKhoan() ?></td>
            <td><?= $tk->loaiTaiKhoan() ?></td>
            <td><?= number_format($tk->laySoDu(), 0, ',', '.') ?> VNĐ</td>
            <td>
              <?php if (method_exists($tk, 'tinhLaiSuatNam')): ?>
                <?= number_format($tk->tinhLaiSuatNam(), 0, ',', '.') ?> VNĐ
              <?php else: ?>
                -
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>

      <p><strong>Tổng số tài khoản:</strong> <?= \XYZBank\TaiKhoan\NganHang::layTongSoTaiKhoan() ?></p>
      <p><strong>Tên ngân hàng:</strong> <?= \XYZBank\TaiKhoan\NganHang::tenNganHang() ?></p>
    </div>
  </div>
</div>
</body>
</html>
