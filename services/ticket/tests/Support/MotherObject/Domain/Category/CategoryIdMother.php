<?php
declare(strict_types=1);

namespace Ticket\Tests\Support\MotherObject\Domain\Category;

use Ticket\Domain\Category\CategoryId;

final class CategoryIdMother
{
    public static function create(string $categoryId): CategoryId
    {
        return CategoryId::fromString($categoryId);
    }

    public static function createDefault(): CategoryId
    {
        return CategoryId::fromString('ID-CATEGORY-1');
    }
}