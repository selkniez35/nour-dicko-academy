<?php

namespace App\Dto\User;

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