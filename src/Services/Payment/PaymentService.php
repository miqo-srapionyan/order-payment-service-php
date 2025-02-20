<?php

declare(strict_types=1);

namespace App\Services\Payment;

class PaymentService
{
    public function __construct(private readonly PaymentFactory $paymentFactory)
    {
    }

    /**
     * @param int    $userId
     * @param float  $amount
     * @param string $paymentSource
     *
     * @return bool
     * @throws \Exception
     */
    public function processPayment(int $userId, float $amount, string $paymentSource): bool
    {
        $paymentMethod = $this->paymentFactory->getPaymentMethod($paymentSource);

        return $paymentMethod->processPayment($userId, $amount);
    }
}
