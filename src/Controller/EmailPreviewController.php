<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EmailPreviewController extends AbstractController
{
    #[Route('/preview/email/{template}', name: 'app_email_preview')]
    public function preview(string $template): Response
    {
        $fakeData = [
            'firstName' => 'Ahmed',
            'lastName' => 'Martin',
            'email' => 'ahmed.martin@email.com',
            'course' => 'Langue arabe',
            'formula' => '1 cours — 250 €/an',
            'paymentMethod' => 'En 1 fois',
            'paymentType' => 'Virement bancaire',
            'paidAmount' => '250 €',
            'paymentDate' => '12/07/2026',
            'dueDate' => '19/07/2026',
            'startDate' => 'Lundi 04/08/2026',
            'loginUrl' => 'http://localhost:8000/espace-eleve',
            'resetUrl' => 'http://localhost:8000/reset-password',
            'paymentUrl' => 'http://localhost:8000/paiement',
            'courseDate' => 'Lundi 14/07/2026 à 19h00',
            'resourceName' => 'Support — Séance 1',
            'resourceUrl' => 'http://localhost:8000/espace-eleve',
            'announcementTitle' => 'Organisation d\'une Omra',
            'announcementBody' => 'Nous sommes ravis de vous annoncer l\'organisation d\'une Omra pour notre communauté. Les places sont limitées, inscrivez-vous dès maintenant pour réserver la vôtre.',
            'announcementUrl' => 'https://nourdicko-academy.fr/actualites',
            'announcementCta' => 'S\'inscrire à l\'Omra',
        ];

        return $this->render('emails/' . $template . '.html.twig', $fakeData);
    }
}
