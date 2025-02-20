<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Services\Payment\PaymentService;
use App\Services\Payment\PaymentFactory;
use App\Services\Payment\Strategies\CreditCardPayment;

class PaymentServiceTest extends TestCase
{
    private PaymentService $paymentService;
    private $paymentFactoryMock;
    private $creditCardPaymentMock;

    protected function setUp(): void
    {
        // Mock PaymentFactory
        $this->paymentFactoryMock = $this->createMock(PaymentFactory::class);

        // Mock CreditCardPayment strategy
        $this->creditCardPaymentMock = $this->createMock(CreditCardPayment::class);

        // Initialize PaymentService with the mocked PaymentFactory
        $this->paymentService = new PaymentService($this->paymentFactoryMock);
    }

    public function testProcessPaymentSuccess()
    {
        // Ensure the factory returns the mock payment strategy
        $this->paymentFactoryMock
            ->method('getPaymentMethod')
            ->with('credit_card')
            ->willReturn($this->creditCardPaymentMock);

        // Simulate a successful payment
        $this->creditCardPaymentMock
            ->method('processPayment')
            ->willReturn(true);

        $result = $this->paymentService->processPayment(1, 100.0, 'credit_card');

        $this->assertTrue($result);
    }

    public function testProcessPaymentFailure()
    {
        $this->paymentFactoryMock
            ->method('getPaymentMethod')
            ->with('credit_card')
            ->willReturn($this->creditCardPaymentMock);

        $this->creditCardPaymentMock
            ->method('processPayment')
            ->willReturn(false);

        $result = $this->paymentService->processPayment(1, 100.0, 'credit_card');

        $this->assertFalse($result);
    }

    public function testProcessPaymentWithUnknownMethodThrowsException()
    {
        $this->paymentFactoryMock
            ->method('getPaymentMethod')
            ->with('unknown_method')
            ->willThrowException(new Exception("Unknown Payment Method: unknown_method"));

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Unknown Payment Method: unknown_method");

        $this->paymentService->processPayment(1, 100.0, 'unknown_method');
    }
}
