<?php

namespace App\Entity;

use App\Enum\PaymentMethod;
use App\Enum\PaymentStatus;
use App\Repository\PaymentRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: PaymentRepository::class)]
#[ORM\Index(name: 'stripe_session_idx', columns: ['stripe_session_id'])]
class Payment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(unique: true)]
    private string $internalRef;

    #[ORM\Column(length: 255, unique: true)]
    private string $stripeSessionId;

    #[ORM\Column(nullable: true)]
    private ?string $stripePaymentIntent = null;

    #[ORM\Column(length: 20)]
    private PaymentStatus $status = PaymentStatus::PENDING;

    #[ORM\Column]
    private int $amount;

    #[ORM\Column]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $paidAt;

    #[ORM\Column(nullable: true)]
    private ?string $lastStripeEventId = null;

    #[ORM\Column(nullable: true, enumType: PaymentMethod::class)]
    private ?PaymentMethod $method = null;

    public function __construct(){
        $this->paidAt = new DateTimeImmutable();
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getPaidAt(): ?DateTimeImmutable
    {
        return $this->paidAt;
    }

    public function setPaidAt(DateTimeImmutable $paidAt): static
    {
        $this->paidAt = $paidAt;

        return $this;
    }

    public function getMethod(): ?PaymentMethod
    {
        return $this->method;
    }

    public function setMethod(PaymentMethod $method): static
    {
        $this->method = $method;

        return $this;
    }

    public function getStatus(): ?PaymentStatus
    {
        return $this->status;
    }

    public function setStatus(PaymentStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getStripeSessionId(): string
    {
        return $this->stripeSessionId;
    }

    public function setStripeSessionId(string $stripeSessionId): void
    {
        $this->stripeSessionId = $stripeSessionId;
    }

    public function getStripePaymentIntent(): ?string
    {
        return $this->stripePaymentIntent;
    }

    public function setStripePaymentIntent(?string $stripePaymentIntent): self
    {
        $this->stripePaymentIntent = $stripePaymentIntent;
        return $this;
    }

    public function getInternalRef(): string
    {
        return $this->internalRef;
    }

    public function setInternalRef(string $internalRef): void
    {
        $this->internalRef = $internalRef;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getLastStripeEventId(): ?string
    {
        return $this->lastStripeEventId;
    }

    public function setLastStripeEventId(?string $lastStripeEventId): void
    {
        $this->lastStripeEventId = $lastStripeEventId;
    }


}
