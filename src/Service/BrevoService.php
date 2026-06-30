<?php

namespace App\Service;

use App\Entity\Payment;
use GuzzleHttp\Client;
use Brevo\Client\Api\TransactionalEmailsApi;
use Brevo\Client\Configuration;
use Brevo\Client\Model\SendSmtpEmail;

class BrevoService
{
    private TransactionalEmailsApi $api;

    public function __construct(public string $brevoApiKey)
    {
        $config = Configuration::getDefaultConfiguration()
            ->setApiKey('api-key', $brevoApiKey);

        $this->api = new TransactionalEmailsApi(
            new Client(),
            $config
        );
    }

    /**
     * @throws ApiException
     */
    public function sendPaymentConfirmation(Payment $payment): void
    {
        $user = $payment->getUser();

        $mail = new SendSmtpEmail([
            'to' => [
                [
                    'email' => $user->getEmail(),
                    'name' => $user->getProfile()?->getFullName() ?? ''
                ]
            ],

            'templateId' => 8,

            'params' => [
                'FullName' => $user->getProfile()?->getFullName(),
                'Email' => $user->getEmail(),
                'Date' => $payment->getPaidAt()?->format('Y-m-d H:i:s'),
                'Amount' => $payment->getAmount(),
                'Ref' => $payment->getInternalRef(),
            ]
        ]);

        $this->api->sendTransacEmail($mail);
    }
}
