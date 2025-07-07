<?php

declare(strict_types=1);

namespace App\Request;

use ReflectionClass;
use ReflectionException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class AbstractRequest
{
    /**
     * @throws ReflectionException
     */
    public function __construct(
        protected ValidatorInterface $validator,
        protected RequestStack $requestStack,
    ) {
        $this->populate();
        $this->validate();
    }

    public function getRequest(): Request
    {
        return $this->requestStack->getCurrentRequest();
    }

    /**
     * @throws ReflectionException
     */
    protected function populate(): void
    {
        $request = $this->getRequest();
        $reflection = new ReflectionClass($this);

        foreach ($request->toArray() as $property => $value) {
            $attribute = $property;
            if (property_exists($this, $attribute)) {
                $reflectionProperty = $reflection->getProperty($attribute);
                $reflectionProperty->setValue($this, $value);
            }
        }
    }

    protected function validate(): void
    {
        $violations = $this->validator->validate($this);
        if (0 == count($violations)) {
            return;
        }

        $errors = [];

        foreach ($violations as $violation) {
            $attribute = $violation->getPropertyPath();
            $errors[] = [
                'message' => $violation->getMessage(),
                'property' => $attribute,
                'value' => $violation->getInvalidValue(),
            ];

            $response = new JsonResponse(['errors' => $errors], Response::HTTP_BAD_REQUEST);
            $response->send();
        }
    }
}
