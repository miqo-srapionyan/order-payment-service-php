<?php

declare(strict_types=1);

namespace App\Services\Payment\Strategies;

interface PaymentStrategyInterface
{
    public function processPayment(int $userId, float $amount): bool;
}
