<?php

namespace App\Entity;

use App\Repository\MembershipFeatureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MembershipFeatureRepository::class)]
class MembershipFeature
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\Column(length: 10)]
    private ?string $type = null; // card ou modal

    #[ORM\Column]
    private int $position = 0;

    #[ORM\ManyToOne(inversedBy: 'features')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MembershipPlan $membershipPlan = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function getMembershipPlan(): ?MembershipPlan
    {
        return $this->membershipPlan;
    }

    public function setMembershipPlan(?MembershipPlan $membershipPlan): static
    {
        $this->membershipPlan = $membershipPlan;

        return $this;
    }
}
