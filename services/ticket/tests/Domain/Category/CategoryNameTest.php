<?php
declare(strict_types=1);

namespace Ticket\Tests\Domain\Category;

use PHPUnit\Framework\TestCase;
use Ticket\Tests\Support\MotherObject\Domain\Category\CategoryNameMother;

class CategoryNameTest extends TestCase
{
    public function testCreation_HaveTooShortName_ThrownException(): void
    {
        // arrange
        $invalidName = '';

        // assert
        $this->expectException(\InvalidArgumentException::class);

        // act
        CategoryNameMother::create($invalidName);
    }

    public function testCreation_HaveTooLongName_ThrownException(): void
    {
        // arrange
        $invalidName = str_repeat('ą', 101);

        // assert
        $this->expectException(\InvalidArgumentException::class);

        // act
        CategoryNameMother::create($invalidName);
    }

    public function testParseToString_HaveValidName_NameHasBeenParsed(): void
    {
        // arrange
        $expectedNameAsString = 'Category name';
        $name = CategoryNameMother::create($expectedNameAsString);

        // act
        $nameAsString = (string)$name;

        // assert
        $this->assertSame($expectedNameAsString, $nameAsString);
    }

    public function testParseToString_HaveMinLengthName_NameHasBeenParsed(): void
    {
        // arrange
        $expectedNameAsString = 'ą';
        $name = CategoryNameMother::create($expectedNameAsString);

        // act
        $nameAsString = (string)$name;

        // assert
        $this->assertSame($expectedNameAsString, $nameAsString);
    }

    public function testParseToString_HaveMaxLengthName_NameHasBeenParsed(): void
    {
        // arrange
        $expectedNameAsString = str_repeat('ą', 100);
        $name = CategoryNameMother::create($expectedNameAsString);

        // act
        $nameAsString = (string)$name;

        // assert
        $this->assertSame($expectedNameAsString, $nameAsString);
    }

    public function testEquals_HaveTwoSameNames_ReturnsTrue(): void
    {
        // arrange
        $nameOne = CategoryNameMother::create('Same name');
        $nameTwo = CategoryNameMother::create('Same name');

        // act
        $equals = $nameOne->equals($nameTwo);

        // assert
        $this->assertTrue($equals);
    }

    public function testEquals_HaveTwoDifferentNames_ReturnsFalse(): void
    {
        // arrange
        $nameOne = CategoryNameMother::create('Name one');
        $nameTwo = CategoryNameMother::create('Name two');

        // act
        $equals = $nameOne->equals($nameTwo);

        // assert
        $this->assertFalse($equals);
    }
}