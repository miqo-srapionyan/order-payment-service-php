<?php

declare(strict_types=1);

namespace App\Services\Payment\Strategies;

class PayPalPayment implements PaymentStrategyInterface
{
    /**
     * @param int   $userId
     * @param float $amount
     *
     * @return bool
     */
    public function processPayment(int $userId, float $amount): bool
    {
        // Simulate PayPal API integration
        return true; // Assume success
    }
}

