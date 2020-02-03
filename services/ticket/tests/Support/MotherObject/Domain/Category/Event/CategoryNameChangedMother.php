<?php
declare(strict_types=1);

namespace Ticket\Tests\Support\MotherObject\Domain\Category\Event;

use Ticket\Domain\Category\CategoryId;
use Ticket\Domain\Category\CategoryName;
use Ticket\Domain\Category\Event\CategoryNameChanged;
use Ticket\Tests\Support\MotherObject\Domain\Category\CategoryIdMother;
use Ticket\Tests\Support\MotherObject\Domain\Category\CategoryNameMother;

class CategoryNameChangedMother
{
    public static function create(CategoryId $id, CategoryName $name): CategoryNameChanged
    {
        return new CategoryNameChanged($id, $name);
    }

    public static function createWithParams(array $params = []): CategoryNameChanged
    {
        $id = $params['id'] ?? CategoryIdMother::createDefault();
        $name = $params['name'] ?? CategoryNameMother::createDefault();

        return new CategoryNameChanged($id, $name);
    }

    public static function createDefault(): CategoryNameChanged
    {
        return self::createWithParams();
    }
}