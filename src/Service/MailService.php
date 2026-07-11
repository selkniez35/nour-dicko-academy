<?php

namespace App\Service;

use App\Entity\Announcement;
use App\Entity\Payment;
use App\Entity\TrainingSession;
use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

final readonly class MailService
{
    public function __construct(private MailerInterface $mailer, private string $senderEmail, private string $senderName) {}

    /**
     * @throws TransportExceptionInterface
     */
    private function send(string $to, string $subject, string $template, array $context = []): void {
        $email = new TemplatedEmail()
            ->from(new Address($this->senderEmail, $this->senderName))
            ->to($to)
            ->subject($subject)
            ->htmlTemplate($template)
            ->context($context);

        $this->mailer->send($email);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendWelcome(User $user): void
    {
        $this->send(
            $user->getEmail(),
            'Bienvenue à la Nour Dicko Academy',
            'emails/welcome.html.twig',
            [
                'user' => $user,
            ]
        );
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendPaymentConfirmation(Payment $payment): void
    {
        $this->send(
            $payment->getUser()->getEmail(),
            'Confirmation de votre paiement',
            'emails/payment_confirmation.html.twig',
            [
                'payment' => $payment,
            ]
        );
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendTrainingBooking(User $user, TrainingSession $session): void
    {
        $this->send(
            $user->getEmail(),
            'Votre réservation',
            'emails/training_booking.html.twig',
            [
                'user' => $user,
                'session' => $session,
            ]
        );
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendAnnouncement(User $user, Announcement $announcement): void
    {
        $this->send(
            $user->getEmail(),
            $announcement->getTitle(),
            'emails/announcement.html.twig',
            [
                'user' => $user,
                'announcement' => $announcement,
            ]
        );
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendPaymentReminder(Payment $payment): void
    {
        $this->send(
            $payment->getUser()->getEmail(),
            'Rappel de paiement',
            'emails/payment_reminder.html.twig',
            [
                'payment' => $payment,
            ]
        );
    }
}
