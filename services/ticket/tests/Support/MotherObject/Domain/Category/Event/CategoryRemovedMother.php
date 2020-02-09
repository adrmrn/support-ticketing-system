<?php
declare(strict_types=1);

namespace Ticket\Tests\Support\MotherObject\Domain\Category\Event;

use Ticket\Domain\Category\CategoryId;
use Ticket\Domain\Category\Event\CategoryRemoved;
use Ticket\Tests\Support\MotherObject\Domain\Category\CategoryIdMother;

class CategoryRemovedMother
{
    public static function create(CategoryId $categoryId): CategoryRemoved
    {
        return new CategoryRemoved($categoryId);
    }

    public static function createDefault(): CategoryRemoved
    {
        return new CategoryRemoved(
            CategoryIdMother::createDefault()
        );
    }
}