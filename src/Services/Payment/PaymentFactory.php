<?php

declare(strict_types=1);

namespace App\Services\Payment;

use App\Services\Payment\Strategies\BankTransferPayment;
use App\Services\Payment\Strategies\CashOnDeliveryPayment;
use App\Services\Payment\Strategies\CreditCardPayment;
use App\Services\Payment\Strategies\PaymentStrategyInterface;
use App\Services\Payment\Strategies\PayPalPayment;
use Exception;

class PaymentFactory
{
    /**
     * Get a payment strategy instance based on the provided payment source.
     *
     * @param string $paymentSource
     *
     * @return PaymentStrategyInterface
     * @throws Exception
     */
    public function getPaymentMethod(string $paymentSource): PaymentStrategyInterface
    {
        return match ($paymentSource) {
            'credit_card' => new CreditCardPayment(),
            'paypal' => new PayPalPayment(),
            'bank_transfer' => new BankTransferPayment(),
            'cod' => new CashOnDeliveryPayment(),
            default => throw new Exception("Unknown Payment Method: $paymentSource"),
        };
    }
}
