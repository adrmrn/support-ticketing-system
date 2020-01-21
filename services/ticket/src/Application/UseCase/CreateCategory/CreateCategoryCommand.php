<?php
declare(strict_types=1);

namespace Ticket\Application\UseCase\CreateCategory;

use Ticket\Domain\User\User;

class CreateCategoryCommand
{
    private string $name;
    private User $author;

    public function __construct(string $name, User $author)
    {
        $this->name = $name;
        $this->author = $author;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function author(): User
    {
        return $this->author;
    }
}