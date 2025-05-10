<?php
function xu_ly_upload() {
    if (!isset($_FILES['minh_chung']) || $_FILES['minh_chung']['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $ten_goc = $_FILES['minh_chung']['name'];
    $tmp = $_FILES['minh_chung']['tmp_name'];
    $kich_thuoc = $_FILES['minh_chung']['size'];
    $ext = strtolower(pathinfo($ten_goc, PATHINFO_EXTENSION));

    $dinh_dang_hop_le = ['jpg', 'png', 'pdf'];
    if (!in_array($ext, $dinh_dang_hop_le)) return null;
    if ($kich_thuoc > 2 * 1024 * 1024) return null;

    $ten_moi = 'upload_' . time() . '_' . basename($ten_goc);
    $duong_dan = __DIR__ . '/../uploads/' . $ten_moi;

    move_uploaded_file($tmp, $duong_dan);
    return $ten_moi;
}
?>
