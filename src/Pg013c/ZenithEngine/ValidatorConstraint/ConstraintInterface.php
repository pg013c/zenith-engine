<?php

declare(strict_types=1);

namespace Pg013c\ZenithEngine\ValidatorConstraint;

use Symfony\Component\Validator\Constraint;

interface ConstraintInterface
{
    public function getConstraint(bool $isRequired): Constraint;
}
