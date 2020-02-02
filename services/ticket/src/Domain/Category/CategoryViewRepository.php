<?php
declare(strict_types=1);

namespace Ticket\Domain\Category;

interface CategoryViewRepository
{
    /**
     * @return CategoryView[]
     */
    public function getAll(): array;
}