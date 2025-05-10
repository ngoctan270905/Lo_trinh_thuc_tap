<?php
session_start();

$GLOBALS['tong_thu'] = 0;
$GLOBALS['tong_chi'] = 0;

if (!isset($_SESSION['giao_dich'])) {
    $_SESSION['giao_dich'] = [];
}

function co_tu_khoa_nhay_cam($note) {
    $keywords = ['nợ xấu', 'vay nóng'];
    foreach ($keywords as $word) {
        if (stripos($note, $word) !== false) return true;
    }
    return false;
}

if (isset($_POST['reset'])) {
    unset($_SESSION['giao_dich']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$errors = [];
$ten = $_POST['ten_giao_dich'] ?? '';
$so_tien = $_POST['so_tien'] ?? '';
$loai = $_POST['loai'] ?? '';
$ghi_chu = $_POST['ghi_chu'] ?? '';
$ngay = $_POST['ngay'] ?? '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['reset'])) {
    if (!preg_match('/^[\p{L}0-9\s]+$/u', $ten)) {
        $errors[] = "Tên giao dịch không hợp lệ.";
    }

    if (!preg_match('/^\d+(\.\d{1,2})?$/', $so_tien) || $so_tien <= 0) {
        $errors[] = "Số tiền phải là số dương.";
    }

    if (empty($ten) || empty($so_tien) || empty($loai) || empty($ngay)) {
        $errors[] = "Vui lòng nhập đầy đủ thông tin bắt buộc.";
    }

    if (empty($errors)) {
        $giao_dich = [
            'ten' => $ten,
            'so_tien' => (float)$so_tien,
            'loai' => $loai,
            'ghi_chu' => $ghi_chu,
            'ngay' => $ngay,
            'canh_bao' => co_tu_khoa_nhay_cam($ghi_chu),
        ];
        $_SESSION['giao_dich'][] = $giao_dich;

        $ten = $so_tien = $loai = $ghi_chu = $ngay = '';
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý giao dịch tài chính</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Nhập giao dịch mới</h2>

    <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" class="mb-4">
        <div class="form-group">
            <label for="ten_giao_dich">Tên giao dịch:</label>
            <input type="text" class="form-control" name="ten_giao_dich" value="<?= htmlspecialchars($ten) ?>">
        </div>
        <div class="form-group">
            <label for="so_tien">Số tiền:</label>
            <input type="text" class="form-control" name="so_tien" value="<?= htmlspecialchars($so_tien) ?>">
        </div>
        <div class="form-group">
            <label>Loại giao dịch:</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="loai" value="thu" <?= $loai === 'thu' ? 'checked' : '' ?>>
                <label class="form-check-label">Thu</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="loai" value="chi" <?= $loai === 'chi' ? 'checked' : '' ?>>
                <label class="form-check-label">Chi</label>
            </div>
        </div>
        <div class="form-group">
            <label for="ghi_chu">Ghi chú:</label>
            <input type="text" class="form-control" name="ghi_chu" value="<?= htmlspecialchars($ghi_chu) ?>">
        </div>
        <div class="form-group">
            <label for="ngay">Ngày thực hiện:</label>
            <input type="date" class="form-control" name="ngay" value="<?= htmlspecialchars($ngay) ?>">
        </div>
        <button type="submit" class="btn btn-primary btn-block">Lưu giao dịch</button>
    </form>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $err) echo "<li>$err</li>"; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['giao_dich'])): ?>
        <h3>Danh sách giao dịch</h3>
        <table class="table table-bordered table-striped mt-3">
            <thead>
            <tr>
                <th>Tên giao dịch</th>
                <th>Số tiền (USD)</th>
                <th>Loại</th>
                <th>Ghi chú</th>
                <th>Ngày</th>
                <th>Cảnh báo</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($_SESSION['giao_dich'] as $gd): ?>
                <?php
                if ($gd['loai'] === 'thu') $GLOBALS['tong_thu'] += $gd['so_tien'];
                else $GLOBALS['tong_chi'] += $gd['so_tien'];
                ?>
                <tr>
                    <td><?= htmlspecialchars($gd['ten']) ?></td>
                    <td>$<?= number_format($gd['so_tien'], 2) ?></td>
                    <td><?= ucfirst($gd['loai']) ?></td>
                    <td><?= htmlspecialchars($gd['ghi_chu']) ?></td>
                    <td><?= htmlspecialchars($gd['ngay']) ?></td>
                    <td><?= $gd['canh_bao'] ? "<span class='text-danger font-weight-bold'>Cảnh báo</span>" : "Không" ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <h4 class="mt-4">Thống kê</h4>
        <p>Tổng thu: $<?= number_format($GLOBALS['tong_thu'], 2) ?></p>
        <p>Tổng chi: $<?= number_format($GLOBALS['tong_chi'], 2) ?></p>
        <p>Số dư: <strong>$<?= number_format($GLOBALS['tong_thu'] - $GLOBALS['tong_chi'], 2) ?></strong></p>

        <form method="post">
            <button name="reset" class="btn btn-danger mt-3">Xóa tất cả giao dịch</button>
        </form>
    <?php endif; ?>
</div>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
