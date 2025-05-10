<?php
require_once 'includes/logger.php';
require_once 'includes/upload.php';
include 'includes/header.php';

$thong_bao = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hanh_dong = trim($_POST['hanh_dong']);
    if (!empty($hanh_dong)) {
        $file_minh_chung = xu_ly_upload();
        $mo_ta = $hanh_dong;
        if ($file_minh_chung) {
            $mo_ta .= " [Đính kèm: uploads/$file_minh_chung]";
        }
        ghi_nhat_ky($mo_ta);
        $thong_bao = "✅ Đã ghi log thành công.";
    } else {
        $thong_bao = "❌ Vui lòng nhập hành động.";
    }
}
?>

<?php if ($thong_bao): ?>
    <div class="alert alert-info"><?= $thong_bao ?></div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data" class="mb-4">
    <div class="form-group">
        <label>Nhập hành động:</label>
        <input type="text" name="hanh_dong" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Tải file minh chứng (jpg, png, pdf - tối đa 2MB):</label>
        <input type="file" name="minh_chung" class="form-control-file">
    </div>
    <button type="submit" class="btn btn-success">Ghi nhật ký</button>
    <a href="view_log.php" class="btn btn-primary ml-2">Xem nhật ký</a>
</form>
</body>
</html>
