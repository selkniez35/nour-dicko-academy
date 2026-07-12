<?php

namespace App\Entity;

use App\Repository\ClubEventRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClubEventRepository::class)]
class ClubEvent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private string $title = '';

    #[ORM\Column(type: 'text')]
    private string $description = '';

    #[ORM\Column(length: 32)]
    private string $type = 'stage';

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $startAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $endAt;

    #[ORM\Column]
    private int $maxParticipants = 30;

    #[ORM\Column(options: ['default' => true])]
    private bool $isPublished = true;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    /** @var Collection<int, EventRegistration> */
    #[ORM\OneToMany(targetEntity: EventRegistration::class, mappedBy: 'event', cascade: ['remove'])]
    private Collection $registrations;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->startAt = new DateTimeImmutable();
        $this->endAt = new DateTimeImmutable('+2 hours');
        $this->registrations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = strtolower($type);

        return $this;
    }

    public function getStartAt(): DateTimeImmutable
    {
        return $this->startAt;
    }

    public function setStartAt(DateTimeImmutable $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): DateTimeImmutable
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

    public function isPublished(): bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return Collection<int, EventRegistration>
     */
    public function getRegistrations(): Collection
    {
        return $this->registrations;
    }

    public function getParticipantsCount(): int
    {
        return $this->registrations->count();
    }

    public function isFull(): bool
    {
        return $this->getParticipantsCount() >= $this->maxParticipants;
    }

    public function getTypeLabel(): string
    {
        return match ($this->type) {
            'competition' => 'Competition',
            'open_day' => 'Portes ouvertes',
            default => 'Stage',
        };
    }
}
