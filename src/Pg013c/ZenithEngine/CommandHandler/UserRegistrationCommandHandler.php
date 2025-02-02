<?php

declare(strict_types=1);

namespace Pg013c\ZenithEngine\CommandHandler;

use Pg013c\ZenithEngine\Command\UserRegistrationCommand;

class UserRegistrationCommandHandler
{
    public function handle(UserRegistrationCommand $userRegistrationCommand): void
    {
        var_dump($userRegistrationCommand);
        die;
    }
}