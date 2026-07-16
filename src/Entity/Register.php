<?php

namespace App\Entity;

use App\Enum\StudentLevelEnum;
use App\Repository\RegisterRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RegisterRepository::class)]
class Register
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userProfiles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserProfile $userProfile = null;

    #[ORM\ManyToOne(inversedBy: 'registers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MembershipPlan $membershipPlan = null;

    #[ORM\Column(type: 'string', enumType: StudentLevelEnum::class)]
    private StudentLevelEnum $studentLevel;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserProfile(): ?UserProfile
    {
        return $this->userProfile;
    }

    public function setUserProfile(?UserProfile $userProfile): static
    {
        $this->userProfile = $userProfile;

        return $this;
    }

    public function getMembershipPlan(): ?MembershipPlan
    {
        return $this->membershipPlan;
    }

    public function setMembershipPlan(?MembershipPlan $membershipPlan): void
    {
        $this->membershipPlan = $membershipPlan;
    }

    public function getStudentLevel(): StudentLevelEnum
    {
        return $this->studentLevel;
    }

    public function setStudentLevel(StudentLevelEnum $studentLevel): void
    {
        $this->studentLevel = $studentLevel;
    }

}
