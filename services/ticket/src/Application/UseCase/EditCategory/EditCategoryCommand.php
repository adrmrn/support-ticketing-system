<?php
declare(strict_types=1);

namespace Ticket\Application\UseCase\EditCategory;

class EditCategoryCommand
{
    private string $categoryId;
    private string $name;

    public function __construct(string $categoryId, string $name)
    {
        $this->categoryId = $categoryId;
        $this->name = $name;
    }

    public function categoryId(): string
    {
        return $this->categoryId;
    }

    public function name(): string
    {
        return $this->name;
    }
}