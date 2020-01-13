<?php
declare(strict_types=1);

namespace Ticket\Application\UseCase\EditCategory;

class EditCategoryCommand
{
    private string $categoryId;
    private string $name;
    private string $executorId;

    public function __construct(string $categoryId, string $name, string $executorId)
    {
        $this->categoryId = $categoryId;
        $this->name = $name;
        $this->executorId = $executorId;
    }

    public function categoryId(): string
    {
        return $this->categoryId;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function executorId(): string
    {
        return $this->executorId;
    }
}