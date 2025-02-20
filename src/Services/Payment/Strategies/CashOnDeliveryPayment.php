<?php

declare(strict_types=1);

namespace App\Services\Payment\Strategies;

class CashOnDeliveryPayment implements PaymentStrategyInterface
{
    /**
     * @param int   $userId
     * @param float $amount
     *
     * @return bool
     */
    public function processPayment(int $userId, float $amount): bool
    {
        // No actual payment processing needed
        return true;
    }
}
