<?php
declare(strict_types=1);

namespace Ticket\Tests\Domain\Category;

use PHPUnit\Framework\TestCase;
use Ticket\Tests\Support\MotherObject\Domain\Category\CategoryIdMother;
use Ticket\Tests\Support\MotherObject\Domain\Category\CategoryMother;
use Ticket\Tests\Support\MotherObject\Domain\Category\CategoryNameMother;

class CategoryTest extends TestCase
{
    public function testCreation_HaveAllRequiredValues_CreatedCategoryHasExpectedValues(): void
    {
        // arrange
        $expectedId = CategoryIdMother::createDefault();
        $expectedName = CategoryNameMother::createDefault();
        $createdAtAsString = '2020-01-01 14:45:45';

        // act
        $category = CategoryMother::create($expectedId, $expectedName);

        // assert
        $this->assertEquals($expectedId, $category->id());
        $this->assertEquals($expectedName, $category->name());
    }

    public function testRename_HaveNewNameOfCategory_NameHasBeenChanged(): void
    {
        // arrange
        $oldName = CategoryNameMother::create('Old category name');
        $category = CategoryMother::createWithParams([
            'name' => $oldName
        ]);
        $expectedNewName = CategoryNameMother::create('New category name');

        // act
        $category->rename($expectedNewName);

        // assert
        $this->assertEquals($expectedNewName, $category->name());
    }
}