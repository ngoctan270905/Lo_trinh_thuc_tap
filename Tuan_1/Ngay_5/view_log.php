<?php include 'includes/header.php'; ?>

<form method="post" class="mb-4">
    <label>Chọn ngày để xem log:</label>
    <input type="date" name="ngay" class="form-control" required>
    <button type="submit" class="btn btn-primary mt-2">Xem log</button>
    <a href="index.php" class="btn btn-secondary mt-2">← Quay lại</a>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ngay'])) {
    $ngay = $_POST['ngay'];
    $duong_dan = __DIR__ . "/logs/log_$ngay.txt";

    if (file_exists($duong_dan)) {
        echo "<h4>Nhật ký ngày $ngay:</h4><ul class='list-group'>";
        $file = fopen($duong_dan, 'r');
        while (!feof($file)) {
            $dong = fgets($file);
            if ($dong) {
                $class = stripos($dong, 'thất bại') !== false ? 'list-group-item list-group-item-danger' : 'list-group-item';
                echo "<li class='$class'>" . htmlspecialchars($dong) . "</li>";
            }
        }
        fclose($file);
        echo "</ul>";
    } else {
        echo "<div class='alert alert-warning mt-3'>Không có nhật ký cho ngày này.</div>";
    }
}
?>

</body>
</html>
