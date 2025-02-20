<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Logger;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Services\OrderService;
use App\Services\Payment\PaymentService;
use Exception;

use function json_decode;
use function file_get_contents;

class OrderController
{
    /**
     * @var \App\Services\OrderService
     */
    private OrderService $orderService;

    /**
     * @var \App\Repositories\OrderRepository
     */
    private OrderRepository $orderRepository;

    public function __construct(protected ProductRepository $productRepository, protected PaymentService $paymentService)
    {
        $this->orderService = new OrderService($productRepository, $paymentService);
        $this->orderRepository = new OrderRepository();
    }

    /**
     * @return array
     */
    public function store(): array
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $userId = $data['user_id'] ?? null;
        if (!is_numeric($userId) || intval($userId) <= 0) {
            echo json_encode(["error" => "Invalid user_id"]);
            exit;
        }

        $items = $data['items'] ?? [];
        if (!is_array($items) || empty($items)) {
            echo json_encode(["error" => "Items must be a non-empty array"]);
            exit;
        }

        $paymentSource = $data['payment_source'] ?? 'credit_card';

        try {
            $orderData = $this->orderService->placeOrder($userId, $items, $paymentSource);
            $order = $this->orderRepository->create($orderData);

            echo json_encode(['success' => true, 'order_id' => $order->id]);
            exit;
        } catch (Exception $e) {
            Logger::log($e->getMessage());
            echo json_encode(['error' => 'something went wrong']);
        }
        exit;
    }
}
