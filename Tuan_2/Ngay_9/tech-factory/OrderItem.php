<?php
class OrderItem {
    private $conn;
    private $table_name = "order_items";

    public $id;
    public $order_id;
    public $product_id;
    public $quantity;
    public $price_at_order_time;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Thêm chi tiết đơn hàng
    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                (order_id, product_id, quantity, price_at_order_time)
                VALUES
                (:order_id, :product_id, :quantity, :price_at_order_time)";

        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu
        $this->order_id = htmlspecialchars(strip_tags($this->order_id));
        $this->product_id = htmlspecialchars(strip_tags($this->product_id));
        $this->quantity = htmlspecialchars(strip_tags($this->quantity));
        $this->price_at_order_time = htmlspecialchars(strip_tags($this->price_at_order_time));

        // Bind các giá trị
        $stmt->bindParam(":order_id", $this->order_id);
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":price_at_order_time", $this->price_at_order_time);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Đọc chi tiết đơn hàng theo order_id
    public function readByOrderId() {
        $query = "SELECT oi.*, p.product_name 
                FROM " . $this->table_name . " oi
                LEFT JOIN products p ON oi.product_id = p.id
                WHERE oi.order_id = :order_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":order_id", $this->order_id);
        $stmt->execute();
        return $stmt;
    }

    // Tính tổng tiền đơn hàng
    public function calculateTotal() {
        $query = "SELECT SUM(quantity * price_at_order_time) as total
                FROM " . $this->table_name . "
                WHERE order_id = :order_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":order_id", $this->order_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }
} 