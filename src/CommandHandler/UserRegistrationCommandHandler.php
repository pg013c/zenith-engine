<?php

declare(strict_types=1);

namespace App\CommandHandler;

use App\Command\UserRegistrationCommand;

class UserRegistrationCommandHandler
{
    public function handle(UserRegistrationCommand $userRegistrationCommand): void
    {
        var_dump($userRegistrationCommand);
        die;
    }
}