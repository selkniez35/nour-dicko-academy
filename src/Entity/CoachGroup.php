<?php

namespace App\Entity;

use App\Repository\CoachGroupRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoachGroupRepository::class)]
class CoachGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 120)]
    private string $name = '';

    #[ORM\Column(length: 32)]
    private string $level = 'INTERMEDIATE';

    #[ORM\Column(options: ['default' => false])]
    private bool $isInclusive = false;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $coach = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
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

    public function isInclusive(): bool
    {
        return $this->isInclusive;
    }

    public function setIsInclusive(bool $isInclusive): self
    {
        $this->isInclusive = $isInclusive;

        return $this;
    }

    public function getCoach(): ?User
    {
        return $this->coach;
    }

    public function setCoach(?User $coach): self
    {
        $this->coach = $coach;

        return $this;
    }

    public function getLevelLabel(): string
    {
        return match ($this->level) {
            'BEGINNER' => 'Debutant',
            'INTERMEDIATE' => 'Intermediaire',
            'COMPETITION' => 'Competition',
            'INCLUSIVE' => 'Inclusif',
            default => ucfirst(strtolower($this->level)),
        };
    }
}
