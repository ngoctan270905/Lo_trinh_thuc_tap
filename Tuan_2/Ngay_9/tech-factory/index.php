<?php
require_once 'db.php';
require_once 'Product.php';
require_once 'Order.php';
require_once 'OrderItem.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$order = new Order($db);
$orderItem = new OrderItem($db);

if(isset($_POST['add_product'])) {
    $product->product_name = $_POST['product_name'];
    $product->unit_price = $_POST['unit_price'];
    $product->stock_quantity = $_POST['stock_quantity'];
    
    if($product->create()) {
        echo "<div class='alert alert-success'>Sản phẩm đã được thêm thành công.</div>";
    } else {
        echo "<div class='alert alert-danger'>Không thể thêm sản phẩm.</div>";
    }
}

if(isset($_POST['add_order'])) {
    $order->order_date = $_POST['order_date'];
    $order->customer_name = $_POST['customer_name'];
    $order->note = $_POST['note'];
    
    if($order_id = $order->create()) {
        foreach($_POST['products'] as $key => $product_id) {
            if($_POST['quantities'][$key] > 0) {
                $orderItem->order_id = $order_id;
                $orderItem->product_id = $product_id;
                $orderItem->quantity = $_POST['quantities'][$key];
                $orderItem->price_at_order_time = $_POST['prices'][$key];
                $orderItem->create();
            }
        }
        echo "<div class='alert alert-success'>Đơn hàng đã được tạo thành công.</div>";
    } else {
        echo "<div class='alert alert-danger'>Không thể tạo đơn hàng.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>TechFactory - Quản lý sản xuất</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="mb-4">TechFactory - Hệ thống quản lý sản xuất</h1>

        <!-- Form thêm sản phẩm -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Thêm sản phẩm mới</h5>
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Tên sản phẩm</label>
                                <input type="text" name="product_name" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Đơn giá</label>
                                <input type="number" name="unit_price" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Số lượng tồn kho</label>
                                <input type="number" name="stock_quantity" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="add_product" class="btn btn-primary">Thêm sản phẩm</button>
                </form>
            </div>
        </div>

        <!-- Form tạo đơn hàng -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Tạo đơn hàng mới</h5>
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Ngày đặt hàng</label>
                            <input type="date" name="order_date" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tên khách hàng</label>
                            <input type="text" name="customer_name" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Ghi chú</label>
                            <input type="text" name="note" class="form-control">
                        </div>
                    </div>

                    <div class="mb-3">
                        <h6>Chi tiết đơn hàng</h6>
                        <div id="order-items">
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <select name="products[]" class="form-select" required>
                                        <?php
                                        $stmt = $product->read();
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            echo "<option value='{$row['id']}' data-price='{$row['unit_price']}'>{$row['product_name']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" name="quantities[]" class="form-control" placeholder="Số lượng" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" name="prices[]" class="form-control" placeholder="Đơn giá" required>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger remove-item">Xóa</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary" id="add-item">Thêm sản phẩm</button>
                    </div>

                    <button type="submit" name="add_order" class="btn btn-primary">Tạo đơn hàng</button>
                </form>
            </div>
        </div>

        <!-- Danh sách sản phẩm -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Danh sách sản phẩm</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>Tồn kho</th>
                            <th>Ngày tạo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $product->read();
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>{$row['id']}</td>";
                            echo "<td>{$row['product_name']}</td>";
                            echo "<td>" . number_format($row['unit_price'], 0, ',', '.') . " VNĐ</td>";
                            echo "<td>{$row['stock_quantity']}</td>";
                            echo "<td>{$row['created_at']}</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Danh sách đơn hàng -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Danh sách đơn hàng</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ngày đặt</th>
                            <th>Khách hàng</th>
                            <th>Ghi chú</th>
                            <th>Tổng tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $order->read();
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $orderItem->order_id = $row['id'];
                            $total = $orderItem->calculateTotal();
                            
                            echo "<tr>";
                            echo "<td>{$row['id']}</td>";
                            echo "<td>{$row['order_date']}</td>";
                            echo "<td>{$row['customer_name']}</td>";
                            echo "<td>{$row['note']}</td>";
                            echo "<td>" . number_format($total, 0, ',', '.') . " VNĐ</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Xử lý thêm/xóa sản phẩm trong đơn hàng
        document.getElementById('add-item').addEventListener('click', function() {
            const template = document.querySelector('#order-items .row').cloneNode(true);
            template.querySelector('select').value = '';
            template.querySelector('input[type="number"]').value = '';
            document.getElementById('order-items').appendChild(template);
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-item')) {
                if (document.querySelectorAll('#order-items .row').length > 1) {
                    e.target.closest('.row').remove();
                }
            }
        });

        // Tự động điền giá khi chọn sản phẩm
        document.addEventListener('change', function(e) {
            if (e.target.tagName === 'SELECT' && e.target.name === 'products[]') {
                const option = e.target.options[e.target.selectedIndex];
                const price = option.dataset.price;
                const priceInput = e.target.closest('.row').querySelector('input[name="prices[]"]');
                priceInput.value = price;
            }
        });
    </script>
</body>
</html> 