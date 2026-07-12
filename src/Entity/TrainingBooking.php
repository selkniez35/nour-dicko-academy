<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity]
class TrainingBooking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private User|UserInterface $user;

    #[ORM\ManyToOne(inversedBy: 'trainingBookings')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?TrainingSession $trainingSession = null;

    #[ORM\Column]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(options: ['default' => false])]
    private bool $checkedIn = false;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?DateTimeImmutable $checkedInAt = null;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?DateTimeImmutable $cancelledAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): User|UserInterface
    {
        return $this->user;
    }

    public function setUser(User|UserInterface $user): void
    {
        $this->user = $user;
    }

    public function getTrainingSession(): TrainingSession
    {
        return $this->trainingSession;
    }

    public function setTrainingSession(TrainingSession $trainingSession): void
    {
        $this->trainingSession = $trainingSession;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function isCheckedIn(): bool
    {
        return $this->checkedIn;
    }

    public function setCheckedIn(bool $checkedIn): void
    {
        $this->checkedIn = $checkedIn;
    }

    public function getCheckedInAt(): ?DateTimeImmutable
    {
        return $this->checkedInAt;
    }

    public function setCheckedInAt(?DateTimeImmutable $checkedInAt): void
    {
        $this->checkedInAt = $checkedInAt;
    }

    public function getCancelledAt(): ?DateTimeImmutable
    {
        return $this->cancelledAt;
    }

    public function setCancelledAt(?DateTimeImmutable $cancelledAt): void
    {
        $this->cancelledAt = $cancelledAt;
    }

    public function isCancelled(): bool
    {
        return $this->cancelledAt !== null;
    }
}