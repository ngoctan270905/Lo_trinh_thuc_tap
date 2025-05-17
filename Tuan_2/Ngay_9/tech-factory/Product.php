<?php
class Product {
    private $conn;
    private $table_name = "products";

    public $id;
    public $product_name;
    public $unit_price;
    public $stock_quantity;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Thêm sản phẩm mới
    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                (product_name, unit_price, stock_quantity, created_at)
                VALUES
                (:product_name, :unit_price, :stock_quantity, :created_at)";

        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu
        $this->product_name = htmlspecialchars(strip_tags($this->product_name));
        $this->unit_price = htmlspecialchars(strip_tags($this->unit_price));
        $this->stock_quantity = htmlspecialchars(strip_tags($this->stock_quantity));
        $this->created_at = date('Y-m-d H:i:s');

        // Bind các giá trị
        $stmt->bindParam(":product_name", $this->product_name);
        $stmt->bindParam(":unit_price", $this->unit_price);
        $stmt->bindParam(":stock_quantity", $this->stock_quantity);
        $stmt->bindParam(":created_at", $this->created_at);

        if($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    // Đọc tất cả sản phẩm
    public function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Đọc sản phẩm theo giá
    public function readByPrice($min_price) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE unit_price > :min_price";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":min_price", $min_price);
        $stmt->execute();
        return $stmt;
    }

    // Đọc sản phẩm theo giá giảm dần
    public function readByPriceDesc() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY unit_price DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Đọc 5 sản phẩm mới nhất
    public function readLatest() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC LIMIT 5";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Cập nhật sản phẩm
    public function update() {
        $query = "UPDATE " . $this->table_name . "
                SET
                    product_name = :product_name,
                    unit_price = :unit_price,
                    stock_quantity = :stock_quantity
                WHERE
                    id = :id";

        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu
        $this->product_name = htmlspecialchars(strip_tags($this->product_name));
        $this->unit_price = htmlspecialchars(strip_tags($this->unit_price));
        $this->stock_quantity = htmlspecialchars(strip_tags($this->stock_quantity));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind các giá trị
        $stmt->bindParam(":product_name", $this->product_name);
        $stmt->bindParam(":unit_price", $this->unit_price);
        $stmt->bindParam(":stock_quantity", $this->stock_quantity);
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Xóa sản phẩm
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
} 