<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\OrderStatusEnum;
use App\Repositories\ProductRepository;
use App\Services\Payment\PaymentService;
use Exception;

use function array_column;
use function count;

class OrderService
{
    public function __construct(private readonly ProductRepository $productRepository, private readonly PaymentService $paymentService)
    {
    }

    /**
     * @param int    $userId
     * @param array  $items
     * @param string $paymentSource
     *
     * @return array
     * @throws \Exception
     */
    public function placeOrder(int $userId, array $items, string $paymentSource): array
    {
        $totalPrice = 0;
        $productIds = array_column($items, 'product_id'); // Get all product IDs from items array

        // Fetch all products at once by their IDs
        $products = $this->productRepository->findByIds($productIds);

        if (count($products) !== count($productIds)) {
            throw new Exception("Some products were not found");
        }

        foreach ($items as $item) {
            // Find the corresponding product for this item
            $product = $products[$item['product_id']] ?? null;

            if (!$product) {
                throw new Exception("Product not found");
            }

            if ($product->stock < $item['quantity']) {
                throw new Exception("Product '{$product->name}' is not available in sufficient quantity");
            }

            $totalPrice += $product->price * $item['quantity'];
        }

        // Process Payment
        $paymentSuccess = $this->paymentService->processPayment($userId, $totalPrice, $paymentSource);

        if (!$paymentSuccess) {
            throw new Exception("Payment failed");
        }

        return [
            'user_id'     => $userId,
            'items'       => $items,
            'total_price' => $totalPrice,
            'status'      => OrderStatusEnum::SUCCESS->value,
        ];
    }
}
