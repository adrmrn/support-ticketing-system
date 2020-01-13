<?php
declare(strict_types=1);

namespace Ticket\Application\UseCase\CreateCategory;

class CreateCategoryCommand
{
    private string $name;
    private string $authorId;

    public function __construct(string $name, string $authorId)
    {
        $this->name = $name;
        $this->authorId = $authorId;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function authorId(): string
    {
        return $this->authorId;
    }
}