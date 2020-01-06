<?php
declare(strict_types=1);

namespace User\Core\Infrastructure\Delivery\Api\Request\Validator;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Factory as ValidatorFactory;

abstract class Validator
{
    private ValidatorFactory $validatorFactory;
    private array $errors = [];

    public function __construct(ValidatorFactory $validatorFactory)
    {
        $this->validatorFactory = $validatorFactory;
    }

    public function errors(): array
    {
        return $this->errors;
    }

    abstract public function isValid(Request $request): bool;

    protected function validatorFactory(): ValidatorFactory
    {
        return $this->validatorFactory;
    }

    protected function setErrors(MessageBag $messageBag): void
    {
        $this->errors = $messageBag->toArray();
    }
}
