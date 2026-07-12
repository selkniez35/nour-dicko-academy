<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MailPreviewController extends AbstractController
{
    #[Route('/preview/email/confirmation-paiement', name: 'app_email_preview_payment_confirmation')]
    public function paymentConfirmation(): Response
    {
        return $this->render('emails/payment_confirmation.html.twig', [
            'firstName' => 'Mohamed',
            'lastName' => 'Mesbah',
            'course' => 'Lecture du Coran',
            'formula' => 'Paiement en 10 fois',
            'paidAmount' => '35 €',
            'paymentMethod' => 'Carte bancaire',
            'paymentDate' => '12/07/2026',
        ]);
    }
}