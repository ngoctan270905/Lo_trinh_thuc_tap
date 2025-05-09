<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bảng Lương Nhân Viên</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<?php
$nhan_vien = [
    ['ma' => 101, 'ten' => 'Nguyễn Văn A', 'luong_cb' => 5000000],
    ['ma' => 102, 'ten' => 'Trần Thị B', 'luong_cb' => 6000000],
    ['ma' => 103, 'ten' => 'Lê Văn C', 'luong_cb' => 5500000],
];

$cham_cong = [
    101 => ['2025-03-01', '2025-03-02', '2025-03-04', '2025-03-05'],
    102 => ['2025-03-01', '2025-03-03', '2025-03-04'],
    103 => ['2025-03-02', '2025-03-03', '2025-03-04', '2025-03-05', '2025-03-06'],
];

$phu_cap_khau_tru = [
    101 => ['phu_cap' => 500000, 'khau_tru' => 200000],
    102 => ['phu_cap' => 300000, 'khau_tru' => 100000],
    103 => ['phu_cap' => 400000, 'khau_tru' => 150000],
];

const SO_NGAY_CHUAN = 22;

$ngay_cong = array_map(fn($ds) => count(array_unique($ds)), $cham_cong);

$bang_luong = array_map(function ($nv) use ($ngay_cong, $phu_cap_khau_tru) {
    $ma = $nv['ma'];
    $luong_cb = $nv['luong_cb'];
    $so_ngay = $ngay_cong[$ma] ?? 0;
    $phu_cap = $phu_cap_khau_tru[$ma]['phu_cap'] ?? 0;
    $khau_tru = $phu_cap_khau_tru[$ma]['khau_tru'] ?? 0;

    $thuc_linh = round(($luong_cb / SO_NGAY_CHUAN) * $so_ngay + $phu_cap - $khau_tru);

    return array_merge($nv, compact('so_ngay', 'phu_cap', 'khau_tru', 'thuc_linh'));
}, $nhan_vien);
?>

<h3 class="mb-4">BẢNG LƯƠNG NHÂN VIÊN</h3>
<table class="table table-bordered table-striped">
    <thead class="thead-dark">
    <tr>
        <th>Mã NV</th>
        <th>Họ tên</th>
        <th>Ngày công</th>
        <th>Lương cơ bản</th>
        <th>Phụ cấp</th>
        <th>Khấu trừ</th>
        <th>Thực lĩnh</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($bang_luong as $nv): ?>
        <tr>
            <td><?= $nv['ma'] ?></td>
            <td><?= $nv['ten'] ?></td>
            <td><?= $nv['so_ngay'] ?></td>
            <td><?= number_format($nv['luong_cb']) ?></td>
            <td><?= number_format($nv['phu_cap']) ?></td>
            <td><?= number_format($nv['khau_tru']) ?></td>
            <td><strong><?= number_format($nv['thuc_linh']) ?></strong></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php
$tong_quy_luong = array_reduce($bang_luong, fn($tong, $nv) => $tong + $nv['thuc_linh'], 0);
echo "<p><strong>Tổng quỹ lương:</strong> " . number_format($tong_quy_luong) . " VND</p>";

$ma_max = array_keys($ngay_cong, max($ngay_cong))[0];
$ma_min = array_keys($ngay_cong, min($ngay_cong))[0];

$ten_theo_ma = array_column($nhan_vien, 'ten', 'ma');
echo "<p><strong>Người làm nhiều nhất:</strong> {$ten_theo_ma[$ma_max]} ({$ngay_cong[$ma_max]} ngày)</p>";
echo "<p><strong>Người làm ít nhất:</strong> {$ten_theo_ma[$ma_min]} ({$ngay_cong[$ma_min]} ngày)</p>";

$du_thuong = array_filter($bang_luong, fn($nv) => $nv['so_ngay'] >= 4);
echo "<p><strong>Nhân viên đủ điều kiện thưởng:</strong><br>";
foreach ($du_thuong as $nv) {
    echo "- {$nv['ten']} ({$nv['so_ngay']} ngày)<br>";
}
echo "</p>";

$ngay_kiem_tra = '2025-03-03';
$ten_nv_kiem_tra = 'Trần Thị B';
$co_di_lam = in_array($ngay_kiem_tra, $cham_cong[102]);
echo "<p>{$ten_nv_kiem_tra} có đi làm ngày {$ngay_kiem_tra}: <strong>" . ($co_di_lam ? "Có" : "Không") . "</strong></p>";

$kiem_tra_phu_cap = array_key_exists(101, $phu_cap_khau_tru);
echo "<p>Thông tin phụ cấp NV 101 tồn tại: <strong>" . ($kiem_tra_phu_cap ? "Có" : "Không") . "</strong></p>";

array_unshift($cham_cong[101], '2025-03-01');
array_push($cham_cong[101], '2025-03-06');
$cham_cong[101] = array_unique($cham_cong[101]);
?>

</body>
</html>
