<?php
session_start();

if (!isset($_SESSION['gio_hang']) || empty($_SESSION['gio_hang'])) {
    echo "<div class='container mt-5'><div class='alert alert-warning'>⚠️ Giỏ hàng trống!</div></div>";
    exit;
}

$duLieu = json_decode(file_get_contents("cart_data.json"), true);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xác nhận đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="card shadow rounded-4">
        <div class="card-body">
            <h2 class="mb-4 text-primary">🧾 Xác nhận đơn hàng</h2>

            <div class="mb-3">
                <p><strong>📧 Email:</strong> <?= htmlspecialchars($duLieu['email_khach_hang']) ?></p>
                <p><strong>🕒 Thời gian đặt:</strong> <?= $duLieu['thoi_gian_dat'] ?></p>
            </div>

            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Tên sách</th>
                        <th>Đơn giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($duLieu['san_pham'] as $sach): ?>
                    <tr>
                        <td><?= htmlspecialchars_decode($sach['ten']) ?></td>
                        <td><?= number_format($sach['gia']) ?>₫</td>
                        <td><?= $sach['so_luong'] ?></td>
                        <td><?= number_format($sach['gia'] * $sach['so_luong']) ?>₫</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="mt-4">
                <h4 class="text-end">💵 Tổng tiền: <span class="text-danger"><?= number_format($duLieu['tong_tien']) ?>₫</span></h4>
            </div>

            <div class="mt-4 text-end">
                <a href="index.php" class="btn btn-secondary">← Quay lại</a>
                <a href="xoa-gio-hang.php" class="btn btn-danger">🗑️ Xóa giỏ hàng</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
