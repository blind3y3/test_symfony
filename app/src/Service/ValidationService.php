<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\BaseValidationException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationService
{
    /**
     * @throws BaseValidationException
     */
    public function collectErrors(ConstraintViolationListInterface $validationResult): void
    {
        if (count($validationResult) > 0) {
            $errorsBag = [];
            foreach ($validationResult as $error) {
                $errorsBag[] = [$error->getPropertyPath() => $error->getMessage()];
            }
            throw new BaseValidationException((string) $validationResult, $errorsBag);
        }
    }
}
