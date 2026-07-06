<?php

namespace App\Entity;

use App\Repository\EventRegistrationRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRegistrationRepository::class)]
#[ORM\Table(name: 'event_registration', uniqueConstraints: [new ORM\UniqueConstraint(name: 'uniq_event_user_registration', columns: ['event_id', 'user_id'])])]
class EventRegistration
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: ClubEvent::class, inversedBy: 'registrations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ClubEvent $event = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(options: ['default' => false])]
    private bool $checkedIn = false;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?DateTimeImmutable $checkedInAt = null;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEvent(): ?ClubEvent
    {
        return $this->event;
    }

    public function setEvent(ClubEvent $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function isCheckedIn(): bool
    {
        return $this->checkedIn;
    }

    public function setCheckedIn(bool $checkedIn): self
    {
        $this->checkedIn = $checkedIn;

        return $this;
    }

    public function getCheckedInAt(): ?DateTimeImmutable
    {
        return $this->checkedInAt;
    }

    public function setCheckedInAt(?DateTimeImmutable $checkedInAt): self
    {
        $this->checkedInAt = $checkedInAt;

        return $this;
    }
}
