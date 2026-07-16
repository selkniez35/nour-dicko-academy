<?php

namespace App\Dto\User;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[UniqueEntity(
    entityClass: User::class,
    fields: ['email'],
    message: 'Un compte existe déjà avec cette adresse e-mail.',
    errorPath: 'email',
)]
class UserCreateDto
{
    public string $email;
    public string $password;
    public string $firstName;
    public string $lastName;
    public string $fullName;

    /** @var string[] */
    public array $roles = [];

    public bool $autoLogin = false;
}