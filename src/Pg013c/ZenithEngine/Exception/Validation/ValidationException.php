<?php

declare(strict_types=1);

namespace Pg013c\ZenithEngine\Exception\Validation;

use Pg013c\ZenithEngine\Exception\AppException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class ValidationException extends AppException
{
    private ConstraintViolationListInterface $constraintViolationList;

    public function __construct(ConstraintViolationListInterface $constraintViolationList)
    {
        parent::__construct(
            'ValidationError',
            Response::HTTP_BAD_REQUEST
        );
        $this->constraintViolationList = $constraintViolationList;
    }

    public function getConstraintViolationList(): ConstraintViolationListInterface
    {
        return $this->constraintViolationList;
    }
}
