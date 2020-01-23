<?php
declare(strict_types=1);

namespace Ticket\Application\UseCase\RemoveCategory;

use Ticket\Domain\User\User;

class RemoveCategoryCommand
{
    private string $categoryId;
    private User $executor;

    public function __construct(string $categoryId, User $executor)
    {
        $this->categoryId = $categoryId;
        $this->executor = $executor;
    }

    public function categoryId(): string
    {
        return $this->categoryId;
    }

    public function executor(): User
    {
        return $this->executor;
    }
}