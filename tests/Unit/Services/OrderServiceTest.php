<?php

declare(strict_types=1);

namespace Services;

use App\Enums\OrderStatusEnum;
use App\Repositories\ProductRepository;
use App\Services\OrderService;
use App\Services\Payment\PaymentService;
use Exception;
use PHPUnit\Framework\TestCase;

class OrderServiceTest extends TestCase
{
    private ProductRepository $productRepositoryMock;
    private PaymentService $paymentServiceMock;
    private OrderService $orderService;

    protected function setUp(): void
    {
        // Mock dependencies
        $this->productRepositoryMock = $this->createMock(ProductRepository::class);
        $this->paymentServiceMock = $this->createMock(PaymentService::class);

        // Inject mocks into OrderService
        $this->orderService = new OrderService($this->productRepositoryMock, $this->paymentServiceMock);
    }

    public function testPlaceOrderSuccess()
    {
        $userId = 1;
        $items = [
            ['product_id' => 101, 'quantity' => 2],
            ['product_id' => 102, 'quantity' => 1]
        ];

        // Mock product repository response
        $this->productRepositoryMock->method('findByIds')->willReturn([
            101 => (object)['id' => 101, 'name' => 'Product A', 'price' => 100, 'stock' => 5],
            102 => (object)['id' => 102, 'name' => 'Product B', 'price' => 50, 'stock' => 3],
        ]);

        // Mock payment service response
        $this->paymentServiceMock->method('processPayment')->willReturn(true);

        $result = $this->orderService->placeOrder($userId, $items, 'tok_visa');

        $this->assertEquals([
            'user_id'     => $userId,
            'items'       => $items,
            'total_price' => 250,
            'status'      => OrderStatusEnum::SUCCESS->value,
        ], $result);
    }

    public function testPlaceOrderFailsWhenProductNotFound()
    {
        $this->productRepositoryMock->method('findByIds')->willReturn([
            101 => (object)['id' => 101, 'name' => 'Product A', 'price' => 100, 'stock' => 5]
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Some products were not found");

        $this->orderService->placeOrder(1, [
            ['product_id' => 101, 'quantity' => 2],
            ['product_id' => 999, 'quantity' => 1]
        ], 'tok_visa');
    }

    public function testPlaceOrderFailsWhenStockIsInsufficient()
    {
        $this->productRepositoryMock->method('findByIds')->willReturn([
            101 => (object)['id' => 101, 'name' => 'Product A', 'price' => 100, 'stock' => 1]
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Product 'Product A' is not available in sufficient quantity");

        $this->orderService->placeOrder(1, [
            ['product_id' => 101, 'quantity' => 2]
        ], 'tok_visa');
    }

    public function testPlaceOrderFailsWhenPaymentFails()
    {
        $this->productRepositoryMock->method('findByIds')->willReturn([
            101 => (object)['id' => 101, 'name' => 'Product A', 'price' => 100, 'stock' => 5]
        ]);

        $this->paymentServiceMock->method('processPayment')->willReturn(false);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Payment failed");

        $this->orderService->placeOrder(1, [
            ['product_id' => 101, 'quantity' => 1]
        ], 'tok_visa');
    }
}
