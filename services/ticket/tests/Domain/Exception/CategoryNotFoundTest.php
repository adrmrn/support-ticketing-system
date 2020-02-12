<?php
declare(strict_types=1);

namespace Ticket\Tests\Domain\Exception;

use Ticket\Domain\DomainException;
use Ticket\Domain\Exception\CategoryNotFound;
use Ticket\Tests\Support\MotherObject\Domain\Category\CategoryIdMother;
use Ticket\Tests\Support\TestCase;

class CategoryNotFoundTest extends TestCase
{
    public function testCreation_HaveCategoryIdThatDoesNotExist_ReturnedExceptionHasExpectedValues(): void
    {
        // arrange
        $expectedCategoryIdAsString = 'ID-CATEGORY-0';
        $categoryId = CategoryIdMother::create($expectedCategoryIdAsString);

        // act
        $exception = CategoryNotFound::withCategoryId($categoryId);

        // assert
        $this->assertInstanceOf(DomainException::class, $exception);
        $this->assertInstanceOf(CategoryNotFound::class, $exception);
        $expectedMessage = sprintf('Category not found. Category ID: %s', $expectedCategoryIdAsString);
        $this->assertSame($expectedMessage, $exception->getMessage());
    }
}