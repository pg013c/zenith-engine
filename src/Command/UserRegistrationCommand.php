<?php

declare(strict_types=1);

namespace App\Command;

class UserRegistrationCommand
{
    public function __construct(
        private readonly string $username,
        private readonly string $password,
    )
    {
    }

    public function getEmail(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}