<?php
declare(strict_types=1);

namespace Ticket\Application\UseCase\CreateCategory;

class CreateCategoryCommand
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }
}