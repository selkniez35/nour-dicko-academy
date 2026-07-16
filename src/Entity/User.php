<?php

namespace App\Entity;

use App\Enum\UserRole;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'user_app')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?UserProfile $profile = null;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\OneToMany(targetEntity: Payment::class, mappedBy: 'user')]
    private Collection $payments;

    #[ORM\OneToMany(targetEntity: CourseSession::class, mappedBy: 'teacher')]
    private Collection $sessions;

    public function __construct()
    {
        $this->payments = new ArrayCollection();
        $this->sessions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->normalizeRoles($this->roles ?? []);

        if (empty($roles)) {
            $roles = [UserRole::STUDENT->value];
        }

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $this->normalizeRoles($roles);
        return $this;
    }

    public function getProfile(): ?UserProfile
    {
        return $this->profile;
    }

    public function setProfile(UserProfile $profile): self
    {
        $this->profile = $profile;
        $profile->setUser($this);
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function eraseCredentials(): void
    {
    }

    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function setSessions(Collection $sessions): void
    {
        $this->sessions = $sessions;
    }

    private function normalizeRoles(array $roles): array
    {
        $normalized = [];

        foreach ($roles as $role) {
            if (!is_string($role)) {
                continue;
            }

            foreach (explode(',', $role) as $chunk) {
                $value = trim($chunk);
                if ($value !== '') {
                    $normalized[] = $value;
                }
            }
        }

        return array_values(array_unique($normalized));
    }


    public function fullName(): string
    {
        return $this->profile->getFirstName() . ' ' . $this->profile->getLastName();
    }

}
