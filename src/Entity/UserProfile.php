<?php

namespace App\Entity;

use App\Repository\UserProfileRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserProfileRepository::class)]
class UserProfile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firstName = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $dateOfBirth = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $placeOfBirth = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(length: 20, nullable: true, unique: true)]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $gender = null;

    #[ORM\Column(length: 32, nullable: true)]
    private ?string $preferredGroup = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $specificNeeds = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $personalObjective = null;

    #[ORM\Column(options: ['default' => false])]
    private bool $adaptedSupport = false;

    #[ORM\OneToOne(inversedBy: 'profile', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $user = null;
    #[ORM\OneToMany(targetEntity: Membership::class, mappedBy: 'userProfile', cascade: ['persist', 'remove'])]
    private Collection $memberships;

    public function __construct()
    {
        $this->memberships = new ArrayCollection();
    }

    #[ORM\OneToOne(
        cascade: ['persist', 'remove'],
        orphanRemoval: true
    )]
    private ?EmergencyContact $emergencyContact = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTime
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(\DateTime $dateOfBirth): static
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getPlaceOfBirth(): ?string
    {
        return $this->placeOfBirth;
    }

    public function setPlaceOfBirth(string $placeOfBirth): static
    {
        $this->placeOfBirth = $placeOfBirth;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getPreferredGroup(): ?string
    {
        return $this->preferredGroup;
    }

    public function setPreferredGroup(?string $preferredGroup): static
    {
        $this->preferredGroup = $preferredGroup !== null ? strtoupper($preferredGroup) : null;

        return $this;
    }

    public function getSpecificNeeds(): ?string
    {
        return $this->specificNeeds;
    }

    public function setSpecificNeeds(?string $specificNeeds): static
    {
        $this->specificNeeds = $specificNeeds;

        return $this;
    }

    public function getPersonalObjective(): ?string
    {
        return $this->personalObjective;
    }

    public function setPersonalObjective(?string $personalObjective): static
    {
        $this->personalObjective = $personalObjective;

        return $this;
    }

    public function isAdaptedSupport(): bool
    {
        return $this->adaptedSupport;
    }

    public function setAdaptedSupport(bool $adaptedSupport): static
    {
        $this->adaptedSupport = $adaptedSupport;

        return $this;
    }

    public function getEmergencyContact(): ?EmergencyContact
    {
        return $this->emergencyContact;
    }

    public function setEmergencyContact(?EmergencyContact $emergencyContact): void
    {
        $this->emergencyContact = $emergencyContact;
    }

    public function getMemberships(): Collection
    {
        return $this->memberships;
    }

    public function setMemberships(Collection $memberships): void
    {
        $this->memberships = $memberships;
    }

    public function addMembership(Membership $membership): self
    {
        if (!$this->memberships->contains($membership)) {
            $this->memberships->add($membership);
            $membership->setUserProfile($this);
        }

        return $this;
    }

    public function removeMembership(Membership $membership): self
    {
        if ($this->memberships->removeElement($membership)) {
            if ($membership->getUserProfile() === $this) {
                $membership->setUserProfile(null);
            }
        }

        return $this;
    }

    public function getFullName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }

}
