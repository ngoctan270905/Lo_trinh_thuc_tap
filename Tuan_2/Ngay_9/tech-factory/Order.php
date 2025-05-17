<?php
class Order {
    private $conn;
    private $table_name = "orders";

    public $id;
    public $order_date;
    public $customer_name;
    public $note;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Tạo đơn hàng mới
    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                (order_date, customer_name, note)
                VALUES
                (:order_date, :customer_name, :note)";

        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu
        $this->order_date = htmlspecialchars(strip_tags($this->order_date));
        $this->customer_name = htmlspecialchars(strip_tags($this->customer_name));
        $this->note = htmlspecialchars(strip_tags($this->note));

        // Bind các giá trị
        $stmt->bindParam(":order_date", $this->order_date);
        $stmt->bindParam(":customer_name", $this->customer_name);
        $stmt->bindParam(":note", $this->note);

        if($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    // Đọc tất cả đơn hàng
    public function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Đọc chi tiết đơn hàng
    public function readOne() {
        $query = "SELECT o.*, oi.*, p.product_name 
                FROM " . $this->table_name . " o
                LEFT JOIN order_items oi ON o.id = oi.order_id
                LEFT JOIN products p ON oi.product_id = p.id
                WHERE o.id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        return $stmt;
    }
} 