<?php
declare(strict_types=1);

namespace Ticket\Tests\Support\MotherObject\Domain\Category\Event;

use Ticket\Domain\Category\CategoryId;
use Ticket\Domain\Category\CategoryName;
use Ticket\Domain\Category\Event\CategoryCreated;
use Ticket\Tests\Support\MotherObject\Domain\Category\CategoryIdMother;
use Ticket\Tests\Support\MotherObject\Domain\Category\CategoryNameMother;

class CategoryCreatedMother
{
    public static function create(CategoryId $id, CategoryName $name): CategoryCreated
    {
        return new CategoryCreated($id, $name);
    }

    public static function createWithParams(array $params = []): CategoryCreated
    {
        $id = $params['id'] ?? CategoryIdMother::createDefault();
        $name = $params['name'] ?? CategoryNameMother::createDefault();

        return new CategoryCreated($id, $name);
    }

    public static function createDefault(): CategoryCreated
    {
        return self::createWithParams();
    }
}