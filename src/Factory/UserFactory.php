<?php

namespace App\Factory;

use App\Dto\User\UserCreateDto;
use App\Entity\User;
use App\Entity\UserProfile;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class UserFactory
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {}

    public function createFromDto(UserCreateDto $dto): User
    {
        $user = new User();

        // 🔐 User (auth)
        $user->setEmail($dto->email);

        $user->setPassword(
            $this->hasher->hashPassword($user, $dto->password)
        );

        $user->setRoles($dto->roles ?? ['ROLE_USER']);

        // 👤 Profile
        $profile = new UserProfile();
        $profile->setFirstName($dto->firstName);
        $profile->setLastName($dto->lastName);

        $user->setProfile($profile);

        return $user;
    }
}