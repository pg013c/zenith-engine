<?php

declare(strict_types=1);

namespace App\Factory\Command;

use App\Command\UserRegistrationCommand;
use App\Exception\Validation\ValidationException;
use App\Validator\UserRegistrationValidator;
use Symfony\Component\HttpFoundation\Request;

final class UserRegistrationCommandFactory
{
    public function __construct(private readonly UserRegistrationValidator $userRegistrationValidator)
    {
    }

    public function createFromRequest(Request $request): UserRegistrationCommand
    {
        $errors = $this->userRegistrationValidator->validate($request->request->all());

        if (0 < $errors->count()) {
            foreach ($errors as $error) {
                var_dump($error->getMessage());
            }
            die;
//            throw new ValidationException($errors);
        }

        return new UserRegistrationCommand(
            $request->request->get('_username'),
            $request->request->get('_password'),
        );
    }
}