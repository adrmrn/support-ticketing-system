<?php
declare(strict_types=1);

namespace Ticket\Tests\Support\MotherObject\Domain\Category;

use Ticket\Domain\Category\Category;
use Ticket\Domain\Category\CategoryId;
use Ticket\Domain\Category\CategoryName;

class CategoryMother
{
    public static function create(CategoryId $id, CategoryName $name): Category
    {
        return new Category($id, $name);
    }

    public static function createWithParams(array $params = []): Category
    {
        $id = $params['id'] ?? CategoryIdMother::createDefault();
        $name = $params['name'] ?? CategoryNameMother::createDefault();

        return new Category($id, $name);
    }
}