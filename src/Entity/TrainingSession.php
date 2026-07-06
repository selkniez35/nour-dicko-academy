<?php

namespace App\Entity;

use App\Enum\TrainingSessionTypeEnum;
use App\Repository\TrainingSessionRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: TrainingSessionRepository::class)]
class TrainingSession
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: "datetime_immutable")]
    private ?DateTimeImmutable $startAt = null;

    #[ORM\Column(type: "datetime_immutable")]
    private ?DateTimeImmutable $endAt = null;

    #[ORM\Column]
    private int $maxParticipants = 10;

    #[ORM\Column(enumType: TrainingSessionTypeEnum::class)]
    private ?TrainingSessionTypeEnum $type = null;

    #[ORM\Column(length: 32, options: ['default' => 'INTERMEDIATE'])]
    private string $level = 'INTERMEDIATE';

    #[ORM\Column(options: ['default' => false])]
    private bool $isAdapted = false;

    #[ORM\OneToMany(targetEntity: TrainingBooking::class, mappedBy: 'trainingSession')]
    private Collection $trainingBookings;

    public function __construct()
    {
        $this->trainingBookings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartAt(): ?DateTimeImmutable
    {
        return $this->startAt;
    }

    public function setStartAt(DateTimeImmutable $startAt): self
    {
        $this->startAt = $startAt;
        return $this;
    }

    public function getEndAt(): ?DateTimeImmutable
    {
        return $this->endAt;
    }

    public function setEndAt(DateTimeImmutable $endAt): self
    {
        $this->endAt = $endAt;
        return $this;
    }

    public function getMaxParticipants(): int
    {
        return $this->maxParticipants;
    }

    public function setMaxParticipants(int $maxParticipants): self
    {
        $this->maxParticipants = $maxParticipants;
        return $this;
    }

    public function getTrainingBookings(): Collection
    {
        return $this->trainingBookings;
    }

    public function getCurrentParticipants(): int
    {
        return $this->trainingBookings->count();
    }

    public function isFull(): bool
    {
        return $this->getCurrentParticipants() >= $this->maxParticipants;
    }

    public function getType(): ?TrainingSessionTypeEnum
    {
        return $this->type;
    }

    public function setType(?TrainingSessionTypeEnum $type): self
    {
        $this->type = $type;
        return $this;
    }

    #[Assert\Callback]
    public function validateSameDay(ExecutionContextInterface $context): void
    {
        if (!$this->startAt || !$this->endAt) {
            return;
        }

        if ($this->startAt->format('Y-m-d') !== $this->endAt->format('Y-m-d')) {
            $context->buildViolation('La séance doit être sur le même jour.')
                ->atPath('endAt')
                ->addViolation();
        }

        if ($this->endAt <= $this->startAt) {
            $context->buildViolation('La fin doit être après le début.')
                ->atPath('endAt')
                ->addViolation();
        }
    }

    public function getLevel(): string
    {
        return $this->level;
    }

    public function setLevel(string $level): self
    {
        $this->level = strtoupper($level);

        return $this;
    }

    public function isAdapted(): bool
    {
        return $this->isAdapted;
    }

    public function setIsAdapted(bool $isAdapted): self
    {
        $this->isAdapted = $isAdapted;

        return $this;
    }

    public function getLevelLabel(): string
    {
        return match (strtoupper($this->level)) {
            'BEGINNER' => 'Debutant',
            'INTERMEDIATE' => 'Intermediaire',
            'COMPETITION' => 'Competition',
            'INCLUSIVE' => 'Inclusif',
            default => ucfirst(strtolower($this->level)),
        };
    }
}