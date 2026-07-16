<?php

namespace App\Service;

use App\Entity\Announcement;
use App\Entity\Membership;
use App\Entity\MembershipPlan;
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
                'firstName' => $user->getProfile()?->getFirstName(),
                'lastName' => $user->getProfile()?->getLastName(),
                'userEmail' => $user->getEmail(),
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

    /**
     * @throws TransportExceptionInterface
     */
    public function sendMembershipApproved(Membership $membership, string $paymentUrl = '#'): void
    {
        $profile = $membership->getUserProfile();
        $courseLabel = $this->resolveCourseLabel($membership);

        $this->send(
            $profile->getUser()->getEmail(),
            'Votre inscription a été approuvée',
            'emails/inscription_accepted.html.twig',
            [
                'firstName' => $profile->getFirstName(),
                'lastName' => $profile->getLastName(),
                'course' => $courseLabel,
                'paidAmount' => number_format($membership->getPrice(), 2, ',', ' ') . ' €',
                'paymentMethod' => $membership->getPaymentMethod(),
                'paymentUrl' => $paymentUrl,
            ]
        );
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendMembershipRejected(Membership $membership): void
    {
        $profile = $membership->getUserProfile();

        $this->send(
            $profile->getUser()->getEmail(),
            'Votre demande d\'inscription',
            'emails/inscription_rejected.html.twig',
            [
                'firstName' => $profile->getFirstName(),
                'lastName' => $profile->getLastName(),
                'reason' => $membership->getStatusReason()?->label(),
            ]
        );
    }

    private function resolveCourseLabel(Membership $membership): ?string
    {
        if ($membership->getPlan() !== null) {
            return $membership->getPlan()->getLabel();
        }

        $labels = array_map(
            static fn (MembershipPlan $plan): string => $plan->getLabel(),
            $membership->getSelectedCourses()->toArray()
        );

        return $labels !== [] ? implode(' + ', $labels) : null;
    }
}
