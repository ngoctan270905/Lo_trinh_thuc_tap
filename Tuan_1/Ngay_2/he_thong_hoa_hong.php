<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Hệ thống hoa hồng đa cấp</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container mt-5">

<?php 
$nguoi_dung = [
    1 => ['ten' => 'An',     'gioi_thieu' => null],
    2 => ['ten' => 'Bình',   'gioi_thieu' => 1],
    3 => ['ten' => 'Châu',   'gioi_thieu' => 2],
    4 => ['ten' => 'Dũng',   'gioi_thieu' => 3],
    5 => ['ten' => 'Emmy',   'gioi_thieu' => 1],
];

$don_hang = [
    ['ma_don' => 101, 'nguoi_mua' => 4, 'so_tien' => 200.0],  
    ['ma_don' => 102, 'nguoi_mua' => 3, 'so_tien' => 150.0],  
    ['ma_don' => 103, 'nguoi_mua' => 5, 'so_tien' => 300.0],  
];

$ti_le_hoa_hong = [
    1 => 0.10,  
    2 => 0.05,  
    3 => 0.02,  
];

$tong_hoa_hong = [];    
$chi_tiet_hoa_hong = [];   

function lay_chuoi_gioi_thieu(int $id_nguoi_mua, array $ds_nguoi_dung, int $cap_toi_da = 3): array {
    $chuoi = [];
    $id_hien_tai = $id_nguoi_mua;
    $cap = 1;

    while ($cap <= $cap_toi_da && isset($ds_nguoi_dung[$id_hien_tai]['gioi_thieu'])) {
        $nguoi_gt = $ds_nguoi_dung[$id_hien_tai]['gioi_thieu'];
        if ($nguoi_gt === null) break;

        $chuoi[$cap] = $nguoi_gt;
        $id_hien_tai = $nguoi_gt;
        $cap++;
    }

    return $chuoi;
}

function tinh_hoa_hong(array $don_hang, array $ds_nguoi_dung, array $ti_le): array {
    global $tong_hoa_hong, $chi_tiet_hoa_hong;

    foreach ($don_hang as $don) {
        $id_nguoi_mua = $don['nguoi_mua'];
        $so_tien = $don['so_tien'];
        $ma_don = $don['ma_don'];

        $ds_gioi_thieu = lay_chuoi_gioi_thieu($id_nguoi_mua, $ds_nguoi_dung);

        foreach ($ds_gioi_thieu as $cap => $id_gt) {
            $ty_le = $ti_le[$cap] ?? 0;
            $hoa_hong = $so_tien * $ty_le;

            if (!isset($tong_hoa_hong[$id_gt])) {
                $tong_hoa_hong[$id_gt] = 0;
            }
            $tong_hoa_hong[$id_gt] += $hoa_hong;

            $chi_tiet_hoa_hong[] = [
                'nguoi_nhan' => $ds_nguoi_dung[$id_gt]['ten'],
                'nguoi_mua' => $ds_nguoi_dung[$id_nguoi_mua]['ten'],
                'ma_don' => $ma_don,
                'cap' => $cap,
                'so_tien' => $hoa_hong,
            ];
        }
    }

    return [$tong_hoa_hong, $chi_tiet_hoa_hong];
}

list($tong, $chi_tiet) = tinh_hoa_hong($don_hang, $nguoi_dung, $ti_le_hoa_hong);
?>

<h3 class="mb-3">Tổng hoa hồng của từng người</h3>
<table class="table table-bordered table-striped">
  <thead class="thead-dark">
    <tr>
      <th>Người nhận</th>
      <th>Tổng hoa hồng (USD)</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($tong as $id => $tong_tien): ?>
      <tr>
        <td><?= $nguoi_dung[$id]['ten'] ?></td>
        <td>$<?= number_format($tong_tien, 2) ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<h3 class="mt-5 mb-3">Chi tiết hoa hồng theo từng đơn hàng</h3>
<table class="table table-hover table-bordered">
  <thead class="thead-light">
    <tr>
      <th>Người nhận</th>
      <th>Mã đơn</th>
      <th>Người mua</th>
      <th>Cấp giới thiệu</th>
      <th>Hoa hồng (USD)</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($chi_tiet as $dong): ?>
      <tr>
        <td><?= $dong['nguoi_nhan'] ?></td>
        <td><?= $dong['ma_don'] ?></td>
        <td><?= $dong['nguoi_mua'] ?></td>
        <td><?= $dong['cap'] ?></td>
        <td>$<?= number_format($dong['so_tien'], 2) ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

</body>
</html>
