<?php
require __DIR__ . '/../vendor/autoload.php';

class StripePayment {
    private $stripe;

    public function __construct($secretKey) {
        \Stripe\Stripe::setApiKey($secretKey);
        $this->stripe = new \Stripe\StripeClient($secretKey);
    }

    public function createCharge($amount, $currency, $source, $description) {
        return $this->stripe->charges->create([
            'amount' => $amount * 100, // Stripe amount is in cents
            'currency' => $currency,
            'source' => $source,
            'description' => $description,
        ]);
    }
}