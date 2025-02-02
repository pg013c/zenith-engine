<?php

declare(strict_types=1);

namespace Pg013c\ZenithEngine\Validator;

use App\ValidatorConstraint\BoolConstraint;
use Pg013c\ZenithEngine\ValidatorConstraint\EmailConstraint;
use Pg013c\ZenithEngine\ValidatorConstraint\PasswordConstraint;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface as BaseValidatorInterface;

class UserRegistrationValidator
{
    public function __construct(private readonly BaseValidatorInterface $validator)
    {
    }

    public function validate(array $data): ConstraintViolationListInterface
    {
        return $this->validator->validate($data, $this->createConstraints());
    }

    private function createConstraints(): Collection
    {
        return new Collection([
            'fields' => [
                '_username' => (new EmailConstraint())->getConstraint(true, 5, 50),
                '_password' => (new PasswordConstraint())->getConstraint(true, 5, 50),
            ],
        ]);
    }
}