<?php

namespace App\Service;

use App\Dto\User\UserCreateDto;
use App\Entity\User;
use App\Entity\UserProfile;
use App\Repository\UserRepository;
use App\Security\Policy\UserCreationPolicy;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class UserService
{
    public function __construct(private UserRepository $userRepository, private Security $security, private UserPasswordHasherInterface $hasher, private UserCreationPolicy $policy) {}

    public function createUser(UserCreateDto $dto): User
    {
        $user = new User();

        // 🔐 CONTEXT (acteur actuel)
        $actor = $this->security->getUser();

        // 🔐 ROLES (Policy décide selon acteur)
        $roles = $this->policy->sanitizeRoles($dto->roles, $actor);
        $user->setRoles($roles);

        // 🔐 AUTH DATA
        $user->setEmail($dto->email);

        $user->setPassword(
            $this->hasher->hashPassword($user, $dto->password)
        );

        // 👤 PROFILE
        $user->setProfile(
            $this->createProfile($dto)
        );

        // 💾 SAVE
        $this->userRepository->save($user);

        return $user;
    }

    private function createProfile(UserCreateDto $dto): UserProfile
    {
        $profile = new UserProfile();

        $profile->setFirstName($dto->firstName);
        $profile->setLastName($dto->lastName);

        return $profile;
    }
}