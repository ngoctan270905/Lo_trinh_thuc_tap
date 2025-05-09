<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Chiến dịch tài chính</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container mt-5">

<?php
$ten_chien_dich = "Spring_sale 2025";
$so_luong_don_hang = 150;
$gia_san_pham = 99.99;
$ti_le_hoa_hong = 0.2;
$ti_le_vat = 0.1;
$trang_thai = true;

$san_pham = [
  "ID001" => 99.99,
  "ID002" => 69.99,
  "ID003" => 49.99,
  "ID004" => 59.99,
  "ID005" => 79.99,
];

$doanh_thu = $gia_san_pham * $so_luong_don_hang;
$chi_phi_hoa_hong = $doanh_thu * $ti_le_hoa_hong;
$thue_vat = $doanh_thu * $ti_le_vat;
$loi_nhuan = $doanh_thu - $chi_phi_hoa_hong - $thue_vat;
?>

<h3 class="mb-3">Thông tin chiến dịch</h3>
<table class="table table-bordered table-striped">
  <thead class="thead-dark">
    <tr>
      <th>Tên</th>
      <th>Số lượng</th>
      <th>Giá</th>
      <th>Hoa hồng</th>
      <th>VAT</th>
      <th>Trạng thái</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><?= $ten_chien_dich ?></td>
      <td><?= $so_luong_don_hang ?></td>
      <td>$<?= number_format($gia_san_pham, 2) ?></td>
      <td><?= $ti_le_hoa_hong * 100 ?>%</td>
      <td><?= $ti_le_vat * 100 ?>%</td>
      <td><span class="badge badge-<?= $trang_thai ? 'success' : 'warning' ?>">
        <?= $trang_thai ? 'Kết thúc' : 'Đang chạy' ?>
      </span></td>
    </tr>
  </tbody>
</table>

<h3 class="mt-5 mb-3">Kết quả chiến dịch</h3>
<table class="table table-bordered table-hover">
  <thead class="thead-light">
    <tr>
      <th>Doanh thu</th>
      <th>Hoa hồng</th>
      <th>VAT</th>
      <th>Lợi nhuận</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>$<?= number_format($doanh_thu, 2) ?></td>
      <td>$<?= number_format($chi_phi_hoa_hong, 2) ?></td>
      <td>$<?= number_format($thue_vat, 2) ?></td>
      <td><strong>$<?= number_format($loi_nhuan, 2) ?></strong></td>
    </tr>
  </tbody>
</table>

</body>
</html>
