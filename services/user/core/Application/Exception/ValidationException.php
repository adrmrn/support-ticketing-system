<?php
declare(strict_types=1);

namespace User\Core\Application\Exception;

class ValidationException extends \InvalidArgumentException
{
    private array $errors;

    private function __construct(array $errors)
    {
        parent::__construct('Invalid data provided. Validation exception.');

        $this->errors = $errors;
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public static function withErrors(array $errors = []): ValidationException
    {
        return new self($errors);
    }
}
