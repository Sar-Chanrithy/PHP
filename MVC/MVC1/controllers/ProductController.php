<?php
// Require the Model so the Controller can interact with data
require_once __DIR__ . '/../models/ProductModel.php';

// Controller: Coordinates application flow
// 1. Receives input from user/router
// 2. Interacts with Model to fetch or modify data
// 3. Selects and renders the appropriate View with the data
class ProductController {
    private $productModel;

    public function __construct() {
        // Initialize the Model
        $this->productModel = new ProductModel();
    }

    /**
     * Action: List all products
     */
    public function index() {
        // 1. Ask Model for data
        $products = $this->productModel->getAllProducts();

        // 2. Pass data to View and render it
        require __DIR__ . '/../views/product_list.php';
    }

    /**
     * Action: Show a single product's detail
     * @param int $id
     */
    public function detail($id) {
        // 1. Ask Model for specific product by ID
        $product = $this->productModel->getProductById($id);

        // 2. Pass product data to the detail View
        require __DIR__ . '/../views/product_detail.php';
    }
}
