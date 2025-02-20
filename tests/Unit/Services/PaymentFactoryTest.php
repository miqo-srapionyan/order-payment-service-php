<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Services\Payment\PaymentFactory;
use App\Services\Payment\Strategies\CreditCardPayment;
use App\Services\Payment\Strategies\PayPalPayment;
use App\Services\Payment\Strategies\BankTransferPayment;
use App\Services\Payment\Strategies\CashOnDeliveryPayment;

class PaymentFactoryTest extends TestCase
{
    private PaymentFactory $paymentFactory;

    protected function setUp(): void
    {
        $this->paymentFactory = new PaymentFactory();
    }

    public function testGetPaymentMethodReturnsCreditCardPayment()
    {
        $paymentMethod = $this->paymentFactory->getPaymentMethod('credit_card');

        $this->assertInstanceOf(CreditCardPayment::class, $paymentMethod);
    }

    public function testGetPaymentMethodReturnsPayPalPayment()
    {
        $paymentMethod = $this->paymentFactory->getPaymentMethod('paypal');

        $this->assertInstanceOf(PayPalPayment::class, $paymentMethod);
    }

    public function testGetPaymentMethodReturnsBankTransferPayment()
    {
        $paymentMethod = $this->paymentFactory->getPaymentMethod('bank_transfer');

        $this->assertInstanceOf(BankTransferPayment::class, $paymentMethod);
    }

    public function testGetPaymentMethodReturnsCashOnDeliveryPayment()
    {
        $paymentMethod = $this->paymentFactory->getPaymentMethod('cod');

        $this->assertInstanceOf(CashOnDeliveryPayment::class, $paymentMethod);
    }

    public function testGetPaymentMethodThrowsExceptionForUnknownMethod()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Unknown Payment Method: unknown_method");

        $this->paymentFactory->getPaymentMethod('unknown_method');
    }
}
