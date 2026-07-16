<?php

namespace App\Entity;

use App\Repository\MembershipPlanRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MembershipPlanRepository::class)]
class MembershipPlan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length:150)]
    private ?string $label = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(length:100)]
    private ?string $level = null;

    #[ORM\Column(length:255)]
    private ?string $description = null;

    #[ORM\Column(length:150)]
    private ?string $schedule = null;

    #[ORM\Column(length:50)]
    private ?string $icon = null;
    #[ORM\OneToMany(
        targetEntity: MembershipFeature::class,
        mappedBy: 'membershipPlan',
        cascade: ['persist','remove'],
        orphanRemoval: true
    )]

    private Collection $features;

    #[ORM\Column]
    private int $maxStudents = 0;

    public function __construct()
    {
        $this->features = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): void
    {
        $this->label = $label;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): void
    {
        $this->price = $price;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(?string $level): void
    {
        $this->level = $level;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getSchedule(): ?string
    {
        return $this->schedule;
    }

    public function setSchedule(?string $schedule): void
    {
        $this->schedule = $schedule;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): void
    {
        $this->icon = $icon;
    }

    public function getFeatures(): Collection
    {
        return $this->features;
    }

    public function setFeatures(Collection $features): void
    {
        $this->features = $features;
    }

    public function getMaxStudents(): int
    {
        return $this->maxStudents;
    }

    public function setMaxStudents(int $maxStudents): static
    {
        $this->maxStudents = $maxStudents;
        return $this;
    }

    public function isFull(int $enrolledCount): bool
    {
        return $this->maxStudents > 0 && $enrolledCount >= $this->maxStudents;
    }
}
