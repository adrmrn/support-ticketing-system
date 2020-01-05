<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Domain\Category;

use Ticket\Domain\Category\Category;
use Ticket\Domain\Category\CategoryId;
use Ticket\Domain\Category\CategoryRepository;
use Ticket\Domain\Exception\CategoryNotFound;

class DoctrineCategoryRepository implements CategoryRepository
{

    public function nextIdentity(): CategoryId
    {
        // TODO: Implement nextIdentity() method.
    }

    public function add(Category $category): void
    {
        // TODO: Implement add() method.
    }

    /**
     * @inheritDoc
     */
    public function getById(CategoryId $id): Category
    {
        // TODO: Implement getById() method.
    }
}