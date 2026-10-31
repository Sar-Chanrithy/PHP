<?php

class ProductController extends Controller {
    private Product $productModel;
    private string $uploadDir;

    public function __construct(){
        $this->productModel = new Product();
        $this->uploadDir = dirname(__DIR__, 2) . "/public/asset/uploads/";
        if(!is_dir($this->uploadDir)){
            @mkdir($this->uploadDir, 0777, true);
        }
    }

    public function index(){
        $products = $this->productModel->getAll();
        return $this->view("crud-product/index", ["products" => $products]);
    }

    public function create(){
        return $this->view("crud-product/create");
    }

    public function store(){
        $title = trim($_POST['title'] ?? '');
        $price = (float)($_POST['price'] ?? 0);
        $stock = (int)($_POST['stock'] ?? 0);
        $description = trim($_POST['description'] ?? '');
        $imagePath = '';

        // Handle File Upload if provided
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $fileExtension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $newFileName = time() . '_' . uniqid() . '.' . $fileExtension;
            $targetPath = $this->uploadDir . $newFileName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $imagePath = $newFileName;
            }
        } elseif (!empty($_POST['image_url'])) {
            $imagePath = trim($_POST['image_url']);
        }

        $this->productModel->create([
            'title' => $title,
            'price' => $price,
            'stock' => $stock,
            'image' => $imagePath,
            'description' => $description
        ]);

        return $this->redirect('/');
    }

    public function edit(){
        $id = (int)($_GET['id'] ?? 0);
        $product = $this->productModel->find($id);

        if (!$product) {
            return $this->redirect('/');
        }

        return $this->view("crud-product/edit", ["product" => $product]);
    }

    public function update(){
        $id = (int)($_POST['id'] ?? 0);
        $product = $this->productModel->find($id);

        if (!$product) {
            return $this->redirect('/');
        }

        $title = trim($_POST['title'] ?? '');
        $price = (float)($_POST['price'] ?? 0);
        $stock = (int)($_POST['stock'] ?? 0);
        $description = trim($_POST['description'] ?? '');
        $imagePath = $product['image'];

        // If new file uploaded
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $fileExtension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $newFileName = time() . '_' . uniqid() . '.' . $fileExtension;
            $targetPath = $this->uploadDir . $newFileName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                // Delete old file if exists
                if (!empty($product['image']) && !str_starts_with($product['image'], 'http')) {
                    $oldFile = $this->uploadDir . basename($product['image']);
                    if (file_exists($oldFile)) {
                        @unlink($oldFile);
                    }
                }
                $imagePath = $newFileName;
            }
        } elseif (!empty($_POST['image_url'])) {
            $imagePath = trim($_POST['image_url']);
        }

        $this->productModel->update($id, [
            'title' => $title,
            'price' => $price,
            'stock' => $stock,
            'image' => $imagePath,
            'description' => $description
        ]);

        return $this->redirect('/');
    }

    public function delete(){
        $id = (int)($_POST['id'] ?? $_GET['id'] ?? 0);
        if ($id > 0) {
            $product = $this->productModel->find($id);
            if ($product && !empty($product['image']) && !str_starts_with($product['image'], 'http')) {
                $oldFile = $this->uploadDir . basename($product['image']);
                if (file_exists($oldFile)) {
                    @unlink($oldFile);
                }
            }
            $this->productModel->delete($id);
        }
        return $this->redirect('/');
    }
}
