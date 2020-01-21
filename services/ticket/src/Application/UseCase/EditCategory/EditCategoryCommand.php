<?php
declare(strict_types=1);

namespace Ticket\Application\UseCase\EditCategory;

use Ticket\Domain\User\User;

class EditCategoryCommand
{
    private string $categoryId;
    private string $name;
    private User $executor;

    public function __construct(string $categoryId, string $name, User $executor)
    {
        $this->categoryId = $categoryId;
        $this->name = $name;
        $this->executor = $executor;
    }

    public function categoryId(): string
    {
        return $this->categoryId;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function executor(): User
    {
        return $this->executor;
    }
}