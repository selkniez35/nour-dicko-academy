<?php

namespace App\Service;

use App\Entity\Payment;
use App\Entity\TrainingSession;
use App\Entity\UserProfile;
use GuzzleHttp\Client;
use SendinBlue\Client\Api\TransactionalEmailsApi;
use SendinBlue\Client\ApiException;
use SendinBlue\Client\Configuration;
use SendinBlue\Client\Model\SendSmtpEmail;

class BrevoService
{
    private TransactionalEmailsApi $api;

    public function __construct(public string $brevoApiKey)
    {
        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', $brevoApiKey);

        $this->api = new TransactionalEmailsApi(
            new Client(),
            $config
        );
    }

    /**
     * @throws ApiException
     */
    public function sendWelcomeMail(string $email, string $fullName): void
    {
        $mail = new SendSmtpEmail([
            'to' => [
                ['email' => $email]
            ],
            'templateId' => 1,
            'params' => [
                'FullName' => $fullName,
                'Email' => $email
            ]
        ]);

        $this->api->sendTransacEmail($mail);
    }

    /**
     * @throws ApiException
     */
    public function sendTrainingSessionBooking(string $email, UserProfile $userProfile, TrainingSession $session): void {

        $mail = new SendSmtpEmail([
            'to' => [
                ['email' => $email]
            ],
            'templateId' => 7,
            'params' => [
                'FullName' => $userProfile->getFullName(),
                'Email' => $email,
                'Date' => $session->getStartAt()->format('Y-m-d'),
                'StartAt' => $session->getStartAt()->format('H:i'),
                'EndAt' => $session->getEndAt()->format('H:i'),
            ]
        ]);

        $this->api->sendTransacEmail($mail);
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