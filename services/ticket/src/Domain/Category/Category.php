<?php
declare(strict_types=1);

namespace Ticket\Domain\Category;

class Category
{
    private CategoryId $id;
    private CategoryName $name;

    public function __construct(CategoryId $id, CategoryName $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function rename(CategoryName $name): void
    {
        $this->name = $name;
    }

    public function id(): CategoryId
    {
        return $this->id;
    }

    public function name(): CategoryName
    {
        return $this->name;
    }
}