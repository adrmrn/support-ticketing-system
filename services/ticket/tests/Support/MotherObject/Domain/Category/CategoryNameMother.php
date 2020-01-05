<?php
declare(strict_types=1);

namespace Ticket\Tests\Support\MotherObject\Domain\Category;

use Ticket\Domain\Category\CategoryName;

class CategoryNameMother
{
    public static function create(string $name): CategoryName
    {
        return new CategoryName($name);
    }

    public static function createDefault(): CategoryName
    {
        return new CategoryName('Example category name');
    }
}