<?php
/**
 * Entry Point (Front Controller & Basic Router)
 * All user requests arrive here first.
 */

// Include the Controller
require_once __DIR__ . '/controllers/ProductController.php';

// Instantiate the Controller
$controller = new ProductController();

// 1. Detect requested action from URL query string (default: 'index')
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// 2. Dispatch request to appropriate Controller action
switch ($action) {
    case 'detail':
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $controller->detail($id);
        break;

    case 'index':
    default:
        $controller->index();
        break;
}
