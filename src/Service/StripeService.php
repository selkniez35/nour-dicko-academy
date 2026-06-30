<?php

namespace App\Service;

use App\Entity\Payment;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Entity\Membership;

class StripeService
{
    public function __construct(
        private readonly string $stripeSecretKey,
        private readonly string $appUrl
    ) {
        Stripe::setApiKey($this->stripeSecretKey);
    }

    /**
     * @throws ApiErrorException
     */
    public function createCheckoutSession(Payment $payment): string
    {
        $session = Session::create([
            'mode' => 'payment',

            'success_url' => $this->appUrl . '/payment/success?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => $this->appUrl . '/payment/cancel',

            'metadata' => [
                'payment_ref' => $payment->getInternalRef(),
            ],

            'line_items' => [[
                'quantity' => 1,
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $payment->getAmount(),
                    'product_data' => [
                        'name' => 'Adhésion',
                    ],
                ],
            ]],
        ]);

        $payment->setStripeSessionId($session->id);

        return $session->url;
    }
}