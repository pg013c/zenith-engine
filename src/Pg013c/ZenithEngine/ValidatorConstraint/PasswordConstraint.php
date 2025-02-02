<?php

declare(strict_types=1);

namespace Pg013c\ZenithEngine\ValidatorConstraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Optional;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

final class PasswordConstraint implements ConstraintInterface
{
    private const MIN_LENGTH = 3;
    private const MAX_LENGTH = 255;

    public function getConstraint(
        bool $isRequired,
        int $minLength = self::MIN_LENGTH,
        int $maxLength = self::MAX_LENGTH
    ): Constraint {
        $subConstraint = [
            'constraints' => [
                new Type(['type' => 'string']),
                new Length([
                    'min' => $minLength,
                    'max' => $maxLength,
                ]),
            ],
        ];

        if ($isRequired) {
            $subConstraint['constraints'][] = new NotBlank();
        }

        $subConstraint['constraints'][] = new Callback(['callback' => [$this, 'validatePassword']]);

        if ($isRequired) {
            return new Required($subConstraint);
        }

        return new Optional($subConstraint);
    }

    public function validatePassword(?string $password, ExecutionContextInterface $context): void
    {
        $password_regex = '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/';
        $isPasswordValid = preg_match($password_regex, $password);

        if (!$isPasswordValid) {
            $context->buildViolation('Invalid password')->addViolation();
        }
    }
}
