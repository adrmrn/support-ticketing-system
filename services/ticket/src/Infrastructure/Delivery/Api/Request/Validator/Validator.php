<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Delivery\Api\Request\Validator;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationListInterface;

abstract class Validator
{
    private array $errors = [];

    public function __construct(Request $request)
    {
        $this->validate($request);
    }

    public function isValid(): bool
    {
        return \count($this->errors()) === 0;
    }

    public function errors(): array
    {
        return $this->errors;
    }

    abstract protected function validate(Request $request): void;

    protected function mapErrors(ConstraintViolationListInterface $listOfErrors): void
    {
        foreach ($listOfErrors as $error) {
            $fieldName = str_replace(['[', ']'], '', $error->getPropertyPath());
            $this->errors[$fieldName][] = $error->getMessage();
        }
    }
}