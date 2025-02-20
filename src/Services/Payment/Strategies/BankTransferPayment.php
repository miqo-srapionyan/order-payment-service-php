<?php

declare(strict_types=1);

namespace App\Services\Payment\Strategies;

class BankTransferPayment implements PaymentStrategyInterface
{
    /**
     * @param int   $userId
     * @param float $amount
     *
     * @return bool
     */
    public function processPayment(int $userId, float $amount): bool
    {
        // Simulate bank transfer logic
        return true; // Assume success
    }
}

