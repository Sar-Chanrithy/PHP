<?php

$router->get('/', [ProductController::class, 'index']);
$router->get('/products', [ProductController::class, 'index']);
$router->get('/create', [ProductController::class, 'create']);
$router->post('/store', [ProductController::class, 'store']);
$router->get('/edit', [ProductController::class, 'edit']);
$router->post('/update', [ProductController::class, 'update']);
$router->get('/delete', [ProductController::class, 'delete']);
$router->post('/delete', [ProductController::class, 'delete']);
