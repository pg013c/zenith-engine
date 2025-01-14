<?php

declare(strict_types=1);

namespace App\ValidatorConstraint;

use Symfony\Component\Validator\Constraint;

interface ConstraintInterface
{
    public function getConstraint(bool $isRequired): Constraint;
}
