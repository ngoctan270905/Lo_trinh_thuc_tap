<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    if ($email) {
        setcookie('luu_email', $email, time() + (7 * 24 * 60 * 60)); // 7 ngày
    }
}

$loi = '';
$thanhCong = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $tenSach = filter_input(INPUT_POST, 'ten_sach',FILTER_SANITIZE_SPECIAL_CHARS);
        $soLuong = filter_input(INPUT_POST, 'so_luong', FILTER_VALIDATE_INT);
        $gia = filter_input(INPUT_POST, 'gia', FILTER_VALIDATE_INT);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $soDienThoai = filter_input(INPUT_POST, 'so_dien_thoai', FILTER_VALIDATE_REGEXP, [
            "options" => ["regexp" => "/^[0-9]{9,11}$/"]
        ]);
        $diaChi = filter_input(INPUT_POST, 'dia_chi', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!$tenSach || !$soLuong || !$gia || !$email || !$soDienThoai || !$diaChi) {
            throw new Exception("Vui lòng điền đầy đủ thông tin hợp lệ.");
        }

        if (!isset($_SESSION['gio_hang'])) {
            $_SESSION['gio_hang'] = [];
        }

        $daTonTai = false;
        foreach ($_SESSION['gio_hang'] as &$sach) {
            if ($sach['ten'] === $tenSach) {
                $sach['so_luong'] += $soLuong;
                $daTonTai = true;
                break;
            }
        }
        if (!$daTonTai) {
            $_SESSION['gio_hang'][] = [
                'ten' => $tenSach,
                'gia' => $gia,
                'so_luong' => $soLuong
            ];
        }

        $tongTien = 0;
        foreach ($_SESSION['gio_hang'] as $sach) {
            $tongTien += $sach['gia'] * $sach['so_luong'];
        }

        $duLieu = [
            'email_khach_hang' => $email,
            'san_pham' => $_SESSION['gio_hang'],
            'tong_tien' => $tongTien,
            'thoi_gian_dat' => date('Y-m-d H:i:s')
        ];

        if (!file_put_contents("cart_data.json", json_encode($duLieu, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
            throw new Exception("Không thể ghi vào file giỏ hàng.");
        }

        $thanhCong = "Thêm vào giỏ hàng thành công!";
    } catch (Exception $e) {
        $loi = $e->getMessage();
        file_put_contents("loi.log", "[" . date('Y-m-d H:i:s') . "] " . $e->getMessage() . "\n", FILE_APPEND);
    }
}
$emailLuu = $_COOKIE['luu_email'] ?? '';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giỏ hàng sách đơn giản</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h3 class="card-title mb-4 text-center">🛒 Thêm sách vào giỏ hàng</h3>

                <?php if ($loi): ?>
                    <div class="alert alert-danger"><?= $loi ?></div>
                <?php elseif ($thanhCong): ?>
                    <div class="alert alert-success"><?= $thanhCong ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label for="ten_sach" class="form-label">Tên sách</label>
                        <input type="text" name="ten_sach" id="ten_sach" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="gia" class="form-label">Giá (VNĐ)</label>
                        <input type="number" name="gia" id="gia" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="so_luong" class="form-label">Số lượng</label>
                        <input type="number" name="so_luong" id="so_luong" class="form-control" min="1" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" value="<?= htmlspecialchars($emailLuu) ?>" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="so_dien_thoai" class="form-label">Số điện thoại</label>
                        <input type="text" name="so_dien_thoai" id="so_dien_thoai" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="dia_chi" class="form-label">Địa chỉ giao hàng</label>
                        <textarea name="dia_chi" id="dia_chi" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">➕ Thêm vào giỏ hàng</button>
                        <div>
                            <a href="xac-nhan.php" class="btn btn-success">🧾 Xác nhận đặt hàng</a>
                            <a href="xoa-gio-hang.php" class="btn btn-danger">🗑️ Xóa giỏ</a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</body>
</html>
