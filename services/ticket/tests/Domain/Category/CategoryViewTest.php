<?php
declare(strict_types=1);

namespace Ticket\Tests\Domain\Category;

use PHPUnit\Framework\TestCase;
use Ticket\Tests\Support\MotherObject\Domain\Category\CategoryViewMother;

class CategoryViewTest extends TestCase
{
    public function testToArray_HaveView_ReturnedArrayHasExpectedValues(): void
    {
        // arrange
        $id = 'ID-CATEGORY-0';
        $name = 'Category name';
        $categoryView = CategoryViewMother::create($id, $name);

        // act
        $categoryViewAsArray = $categoryView->toArray();

        // act
        $expectedCategoryViewAsArray = [
            'id' => $id,
            'name' => $name
        ];
        $this->assertEquals($expectedCategoryViewAsArray, $categoryViewAsArray);
    }
}