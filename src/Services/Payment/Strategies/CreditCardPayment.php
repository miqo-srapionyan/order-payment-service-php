<?php

declare(strict_types=1);

namespace App\Services\Payment\Strategies;

use App\Core\Logger;
use Exception;
use Stripe\Charge;
use Stripe\Stripe;

use function getenv;

class CreditCardPayment implements PaymentStrategyInterface
{
    public function __construct()
    {
        Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);
    }

    /**
     * @param int   $userId
     * @param float $amount
     *
     * @return bool
     */
    public function processPayment(int $userId, float $amount): bool
    {
        try {
            $charge = Charge::create([
                'amount'      => $amount * 100, // Amount in cents
                'currency'    => 'usd',
                'source'      => 'tok_visa',
                'description' => "Payment for User ID: $userId"
            ]);

            return $charge->status === 'succeeded';
        } catch (Exception $e) {
            Logger::log("Payment error: ".$e->getMessage());

            return false;
        }
    }
}
