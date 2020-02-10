<?php
declare(strict_types=1);

namespace Ticket\Tests\Domain\Category;

use PHPUnit\Framework\TestCase;
use Ticket\Domain\Category\Category;
use Ticket\Domain\Category\Event\CategoryNameChanged;
use Ticket\Domain\Event\DomainEvent;
use Ticket\Tests\Support\Helpers\Shared\Domain\FakeCalendar;
use Ticket\Tests\Support\MotherObject\Domain\Category\Event\CategoryCreatedMother;
use Ticket\Tests\Support\MotherObject\Domain\Category\CategoryIdMother;
use Ticket\Tests\Support\MotherObject\Domain\Category\CategoryMother;
use Ticket\Tests\Support\MotherObject\Domain\Category\Event\CategoryNameChangedMother;
use Ticket\Tests\Support\MotherObject\Domain\Category\CategoryNameMother;

class CategoryTest extends TestCase
{
    public function testCreation_HaveAllRequiredValues_CreatedCategoryHasExpectedValues(): void
    {
        // arrange
        $expectedId = CategoryIdMother::createDefault();
        $expectedName = CategoryNameMother::createDefault();

        // act
        $category = CategoryMother::create($expectedId, $expectedName);

        // assert
        $this->assertEquals($expectedId, $category->id());
        $this->assertEquals($expectedName, $category->name());
    }

    public function testCreation_HaveAllRequiredValues_CategoryCreatedEventRaised(): void
    {
        // arrange
        $id = CategoryIdMother::createDefault();
        $name = CategoryNameMother::createDefault();
        $occurredOnAsString = '2020-01-01 14:45:45';
        FakeCalendar::setFakeDate($occurredOnAsString);

        // act
        $category = CategoryMother::create($id, $name);

        // assert
        $expectedRaisedEvent = CategoryCreatedMother::create($id, $name);
        $this->assertEventRaised($expectedRaisedEvent, $category);
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

    public function testRename_HaveNewNameOfCategory_CategoryChangedEventRaised(): void
    {
        // arrange
        $id = CategoryIdMother::createDefault();
        $oldName = CategoryNameMother::create('Old category name');
        $category = CategoryMother::create($id, $oldName);
        $newName = CategoryNameMother::create('New category name');
        $occurredOnAsString = '2020-01-01 10:00:06';
        FakeCalendar::setFakeDate($occurredOnAsString);

        // act
        $category->rename($newName);

        // assert
        $expectedRaisedEvent = CategoryNameChangedMother::create($id, $newName);
        $this->assertEventRaised($expectedRaisedEvent, $category);
    }

    public function testRename_HaveSameOldAndNewName_CategoryChangedEventNotRaised(): void
    {
        // arrange
        $oldName = CategoryNameMother::create('Category name');
        $category = CategoryMother::createWithParams([
            'name' => $oldName
        ]);
        $newName = CategoryNameMother::create('Category name');

        // act
        $category->rename($newName);

        // assert
        $this->assertEventNotRaised(CategoryNameChanged::class, $category);
    }

    private function assertEventRaised(DomainEvent $expectedEvent, Category $category): void
    {
        $eventRaised = false;
        foreach ($category->popRaisedEvents() as $raisedEvent) {
            if ($expectedEvent == $raisedEvent) {
                $eventRaised = true;
                break;
            }
        }

        $this->assertTrue($eventRaised);
    }

    private function assertEventNotRaised(string $eventClass, Category $category): void
    {
        $eventRaised = false;
        foreach ($category->popRaisedEvents() as $raisedEvent) {
            if (get_class($raisedEvent) === $eventClass) {
                $eventRaised = true;
                break;
            }
        }

        $this->assertFalse($eventRaised);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        FakeCalendar::destroy();
    }
}