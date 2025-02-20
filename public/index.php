<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

// Load environment variables from .env file
App\Core\DotenvHandler::load(__DIR__ . '/..');

use App\Core\Router;
use App\Controllers\OrderController;
use App\Repositories\ProductRepository;
use App\Services\Payment\PaymentFactory;
use App\Services\Payment\PaymentService;

header("Content-Type: application/json");

$paymentFactory = new PaymentFactory();
$productRepository = new ProductRepository();
$paymentService = new PaymentService($paymentFactory);

$router = new Router();
$orderController = new OrderController($productRepository, $paymentService);

// Define API routes
$router->post('/api/orders', [$orderController, 'store']);
$router->get('/api/health', fn() => ['status' => 'ok']);

$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
