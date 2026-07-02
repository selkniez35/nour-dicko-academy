<?php

namespace App\Service;

use App\Entity\Payment;
use App\Entity\MembershipPlan;
use App\Enum\MembershipPlanStatus;
use App\Enum\PaymentMethod;
use App\Enum\PaymentStatus;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

readonly class PaymentService
{
    public function __construct(private EntityManagerInterface $em) {}

    /**
     * Crée un paiement en statut "pending"
     */
    public function createPayment(MembershipPlan $membershipPlan, float $amount, PaymentMethod $method): Payment {
        $payment = new Payment();

        $payment->setMembershipPlan($membershipPlan);
        $payment->setAmount($amount);
        $payment->setMethod($method);
        $payment->setStatus(PaymentStatus::PENDING);
        $payment->setPaidAt(new DateTimeImmutable());

        $this->em->persist($payment);
        $this->em->flush();

        return $payment;
    }

    /**
     * Marque un paiement comme réussi
     * + active la membership
     */
    public function markAsPaid(Payment $payment): void
    {
        $payment->setStatus(PaymentStatus::PAID);
        $payment->setPaidAt(new DateTimeImmutable());

        $membership = $payment->getMembershipPlan();

        $membership?->setStatus(MembershipPlanStatus::ACTIVE);

        $this->em->flush();
    }

    /**
     * Marque un paiement en échec
     */
    public function markAsFailed(Payment $payment): void
    {
        $payment->setStatus(PaymentStatus::REFUNDED);

        $this->em->flush();
    }

    /**
     * Remboursement simple
     */
    public function refund(Payment $payment): void
    {
        $payment->setStatus(PaymentStatus::REFUNDED);

        $membership = $payment->getMembershipPlan();

        $membership?->setStatus(MembershipPlanStatus::SUSPENDED);

        $this->em->flush();
    }
}
