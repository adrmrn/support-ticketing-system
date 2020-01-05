<?php
declare(strict_types=1);

namespace Ticket\Domain\Category;

use Ticket\Domain\Exception\CategoryNotFound;

interface CategoryRepository
{
    public function nextIdentity(): CategoryId;
    public function add(Category $category): void;

    /**
     * @param CategoryId $id
     * @return Category
     * @throws CategoryNotFound
     */
    public function getById(CategoryId $id): Category;
}