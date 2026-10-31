<?php
// Model: Handles data and business logic connected to MySQL
require_once __DIR__ . '/../config/Database.php';

class ProductModel {
    private $db;

    public function __construct() {
        // Obtain PDO connection from Database class
        $this->db = Database::getConnection();
    }

    /**
     * Retrieve all products from the database
     * @return array
     */
    public function getAllProducts() {
        $stmt = $this->db->prepare("SELECT * FROM products ORDER BY id ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Retrieve a single product by its ID
     * @param int $id
     * @return array|null
     */
    public function getProductById($id) {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $product = $stmt->fetch();
        return $product ? $product : null;
    }

    /**
     * Create a new product record
     * @param array $data
     * @return int Inserted ID
     */
    public function createProduct($data) {
        $sql = "INSERT INTO products (name, category, price, stock, description, image) 
                VALUES (:name, :category, :price, :stock, :description, :image)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'name'        => $data['name'],
            'category'    => $data['category'],
            'price'       => $data['price'],
            'stock'       => $data['stock'] ?? 0,
            'description' => $data['description'] ?? '',
            'image'       => $data['image'] ?? ''
        ]);
        return (int)$this->db->lastInsertId();
    }

    /**
     * Update an existing product
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateProduct($id, $data) {
        $sql = "UPDATE products 
                SET name = :name, category = :category, price = :price, stock = :stock, description = :description, image = :image 
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id'          => $id,
            'name'        => $data['name'],
            'category'    => $data['category'],
            'price'       => $data['price'],
            'stock'       => $data['stock'] ?? 0,
            'description' => $data['description'] ?? '',
            'image'       => $data['image'] ?? ''
        ]);
    }

    /**
     * Delete a product by its ID
     * @param int $id
     * @return bool
     */
    public function deleteProduct($id) {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
