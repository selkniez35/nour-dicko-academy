<?php

namespace App\Entity;

use App\Enum\MembershipStatusReason;
use App\Enum\PaymentMethod;
use App\Enum\PaymentModeEnum;
use App\Enum\StudentLevelEnum;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\MembershipStatus;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
class Membership
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\ManyToOne(inversedBy: 'memberships')]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserProfile $userProfile = null;

    #[ORM\Column(length: 20)]
    private string $season;

    #[ORM\Column(nullable: true, enumType: MembershipStatusReason::class)]
    private ?MembershipStatusReason $statusReason = null;

    #[ORM\Column(enumType: MembershipStatus::class)]
    private MembershipStatus $status;

    #[ORM\Column]
    private DateTimeImmutable $createdAt;

    #[ORM\Column]
    private DateTimeImmutable $updatedAt;

    #[ORM\OneToMany(targetEntity: Document::class, mappedBy: 'membership', cascade: ['persist', 'remove'])]
    private Collection $documents;

    #[ORM\Column(type: 'float')]
    private ?float $price = 100;

    #[ORM\OneToMany(
        targetEntity: Payment::class,
        mappedBy: 'membership',
        cascade: ['persist', 'remove'],
        orphanRemoval: true
    )]
    private Collection $payments;

    #[ORM\ManyToOne]
    private ?MembershipPlan $plan = null;

    #[ORM\Column(length: 255, nullable: true, enumType: StudentLevelEnum::class)]
    private ?StudentLevelEnum $studentLevel = null;

    #[ORM\Column(length: 50, nullable: true, enumType: PaymentModeEnum::class)]
    private ?PaymentModeEnum $paymentMode = null;

    #[ORM\Column(length: 50, nullable: true, enumType: PaymentMethod::class)]
    private ?PaymentMethod $paymentMethod = null;

    #[ORM\ManyToMany(targetEntity: MembershipPlan::class)]
    #[ORM\JoinTable(name: 'membership_selected_plans')]
    private Collection $selectedCourses;

    public function __construct()
    {
        $this->payments = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
        $this->documents = new ArrayCollection();
        $this->selectedCourses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getSeason(): string
    {
        return $this->season;
    }

    public function setSeason(string $season): void
    {
        $this->season = $season;
    }

    public function getStatusReason(): ?MembershipStatusReason
    {
        return $this->statusReason;
    }

    public function setStatusReason(?MembershipStatusReason $statusReason): void
    {
        $this->statusReason = $statusReason;
    }

    public function getStatus(): MembershipStatus
    {
        return $this->status;
    }

    public function setStatus(MembershipStatus $status): void
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function addPayment(Payment $payment): self
    {
        if (!$this->payments->contains($payment)) {
            $this->payments->add($payment);
            $payment->setMembership($this);
        }

        return $this;
    }

    public function removePayment(Payment $payment): self
    {
        if ($this->payments->removeElement($payment)) {
            if ($payment->getMembership() === $this) {
                $payment->setMembership(null);
            }
        }

        return $this;
    }

    public function getUserProfile(): ?UserProfile
    {
        return $this->userProfile;
    }

    public function setUserProfile(UserProfile $userProfile): self
    {
        $this->userProfile = $userProfile;
        return $this;
    }

    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function setDocuments(Collection $documents): void
    {
        $this->documents = $documents;
    }

    public function addDocument(Document $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents->add($document);
            $document->setMembership($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        if ($this->documents->removeElement($document)) {
            if ($document->getMembership() === $this) {
                $document->setMembership(null);
            }
        }

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): void
    {
        $this->price = $price;
    }

    public function getPlan(): ?MembershipPlan
    {
        return $this->plan;
    }

    public function setPlan(?MembershipPlan $plan): void
    {
        $this->plan = $plan;
    }

    public function getStudentLevel(): ?StudentLevelEnum
    {
        return $this->studentLevel;
    }

    public function setStudentLevel(?StudentLevelEnum $studentLevel): void
    {
        $this->studentLevel = $studentLevel;
    }

    public function getPaymentMode(): ?PaymentModeEnum
    {
        return $this->paymentMode;
    }

    public function setPaymentMode(?PaymentModeEnum $paymentMode): void
    {
        $this->paymentMode = $paymentMode;
    }

    public function getPaymentMethod(): ?PaymentMethod
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(?PaymentMethod $paymentMethod): void
    {
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * @return Collection<int, MembershipPlan>
     */
    public function getSelectedCourses(): Collection
    {
        return $this->selectedCourses;
    }

    public function addSelectedCourse(MembershipPlan $selectedCourse): self
    {
        if (!$this->selectedCourses->contains($selectedCourse)) {
            $this->selectedCourses->add($selectedCourse);
        }

        return $this;
    }

    public function removeSelectedCourse(MembershipPlan $selectedCourse): self
    {
        $this->selectedCourses->removeElement($selectedCourse);

        return $this;
    }
}
