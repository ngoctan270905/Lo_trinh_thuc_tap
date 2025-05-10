<?php
function ghi_nhat_ky($hanh_dong) {
    $ngay = date('Y-m-d');
    $thoi_gian = date('H:i:s');
    $ip = $_SERVER['REMOTE_ADDR'];
    $dong_log = "[$thoi_gian] - $hanh_dong - IP: $ip" . PHP_EOL;

    $file = __DIR__ . "/../logs/log_$ngay.txt";
    file_put_contents($file, $dong_log, FILE_APPEND);
}
?>
