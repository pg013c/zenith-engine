<?php

declare(strict_types=1);

namespace Pg013c\ZenithEngine\ValidatorConstraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Optional;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\Validator\Constraints\Type;

final class StringConstraint implements ConstraintInterface
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

        if ($isRequired) {
            return new Required($subConstraint);
        }

        return new Optional($subConstraint);
    }
}
