<?php
declare(strict_types=1);

namespace Ticket\Domain;

class Criterion
{
    private string $property;
    private string $value;

    public function __construct(string $property, string $value)
    {
        $this->property = $property;
        $this->value = $value;
    }

    public function property(): string
    {
        return $this->property;
    }

    public function value(): string
    {
        return $this->value;
    }
}