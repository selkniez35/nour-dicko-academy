<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/_preview/mail')]
final class MailPreviewController extends AbstractController
{
    #[Route('/welcome', name: 'mail_preview_welcome')]
    public function welcome(): Response
    {
        return $this->render('emails/welcome.html.twig', [
            'fullName' => 'Nour Dicko',
            'email' => 'contact@nourdickoacademy.com',
        ]);
    }

    #[Route('/payment', name: 'mail_preview_payment')]
    public function payment(): Response
    {
        return $this->render('emails/payment_confirmation.html.twig', [
            'fullName' => 'Nour Dicko',
            'amount' => 129.99,
            'currency' => 'EUR',
            'reference' => 'PAY-2026-000001',
            'date' => new \DateTime(),
        ]);
    }

    #[Route('/announcement', name: 'mail_preview_announcement')]
    public function announcement(): Response
    {
        return $this->render('emails/announcement.html.twig', [
            'fullName' => 'Nour Dicko',
            'announcement' => 'Nouvelle annonce importante !',
        ]);
    }

    #[Route('/booking-confirmation', name: 'mail_preview_booking_confirmation')]
    public function bookingConfirmation(){
        return $this->render('emails/booking_confirmation.html.twig', [
            'fullName' => 'Nour Dicko',
            'date' => new \DateTime(),
        ]);
    }
}
