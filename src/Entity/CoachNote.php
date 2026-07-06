<?php

namespace App\Entity;

use App\Repository\CoachNoteRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoachNoteRepository::class)]
class CoachNote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $coach = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $member = null;

    #[ORM\ManyToOne(targetEntity: TrainingSession::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?TrainingSession $trainingSession = null;

    #[ORM\Column(type: 'smallint', nullable: true)]
    private ?int $techniqueProgress = null;

    #[ORM\Column(type: 'smallint', nullable: true)]
    private ?int $physicalProgress = null;

    #[ORM\Column(type: 'text')]
    private string $comment = '';

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $personalObjective = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCoach(): ?User
    {
        return $this->coach;
    }

    public function setCoach(User $coach): self
    {
        $this->coach = $coach;

        return $this;
    }

    public function getMember(): ?User
    {
        return $this->member;
    }

    public function setMember(User $member): self
    {
        $this->member = $member;

        return $this;
    }

    public function getTrainingSession(): ?TrainingSession
    {
        return $this->trainingSession;
    }

    public function setTrainingSession(?TrainingSession $trainingSession): self
    {
        $this->trainingSession = $trainingSession;

        return $this;
    }

    public function getTechniqueProgress(): ?int
    {
        return $this->techniqueProgress;
    }

    public function setTechniqueProgress(?int $techniqueProgress): self
    {
        $this->techniqueProgress = $techniqueProgress;

        return $this;
    }

    public function getPhysicalProgress(): ?int
    {
        return $this->physicalProgress;
    }

    public function setPhysicalProgress(?int $physicalProgress): self
    {
        $this->physicalProgress = $physicalProgress;

        return $this;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getPersonalObjective(): ?string
    {
        return $this->personalObjective;
    }

    public function setPersonalObjective(?string $personalObjective): self
    {
        $this->personalObjective = $personalObjective;

        return $this;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
