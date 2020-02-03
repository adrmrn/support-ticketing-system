<?php
declare(strict_types=1);

namespace Ticket\Tests\Support\MotherObject\Domain\Category;

use Ticket\Domain\Category\CategoryView;

class CategoryViewMother
{
    public static function create(string $id, string $name): CategoryView
    {
        return new CategoryView($id, $name);
    }

    public static function createWithParams(array $params = []): CategoryView
    {
        $id = $params['id'] ?? (string)CategoryIdMother::createDefault();
        $name = $params['name'] ?? (string)CategoryNameMother::createDefault();

        return new CategoryView($id, $name);
    }
}