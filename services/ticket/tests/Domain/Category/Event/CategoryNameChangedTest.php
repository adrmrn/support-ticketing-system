<?php
declare(strict_types=1);

namespace Ticket\Tests\Domain\Category\Event;

use PHPUnit\Framework\TestCase;
use Ticket\Tests\Support\Helpers\Shared\Domain\FakeCalendar;
use Ticket\Tests\Support\MotherObject\Domain\Category\CategoryIdMother;
use Ticket\Tests\Support\MotherObject\Domain\Category\CategoryNameMother;
use Ticket\Tests\Support\MotherObject\Domain\Category\Event\CategoryNameChangedMother;

class CategoryNameChangedTest extends TestCase
{
    public function testAggregateId_HaveSpecificCategoryIdentifier_ExpectedAggregateIdReturned(): void
    {
        // arrange
        $expectedAggregateId = 'ID-CATEGORY-0';

        // act
        $categoryNameChanged = CategoryNameChangedMother::createWithParams([
            'id' => CategoryIdMother::create($expectedAggregateId)
        ]);
        $aggregateId = $categoryNameChanged->aggregateId();

        // assert
        $this->assertEquals($expectedAggregateId, $aggregateId);
    }

    public function testOccurredOn_HaveOccurredOnDateAsDefault_ExpectedOccurredOnReturned(): void
    {
        // arrange
        $occurredOnAsString = '2020-01-01 14:45:45';
        FakeCalendar::setFakeDate($occurredOnAsString);

        // act
        $categoryNameChanged = CategoryNameChangedMother::createDefault();
        $occurredOn = $categoryNameChanged->occurredOn();

        // assert
        $expectedOccurredOn = new \DateTimeImmutable($occurredOnAsString);
        $this->assertEquals($expectedOccurredOn, $occurredOn);
    }

    public function testVersion_HaveVersionAsDefault_ExpectedVersionOfEventReturned(): void
    {
        // act
        $categoryNameChanged = CategoryNameChangedMother::createDefault();
        $version = $categoryNameChanged->version();

        // assert
        $expectedVersion = 0;
        $this->assertEquals($expectedVersion, $version);
    }

    public function testData_HaveCategoryNameChangedEventWithSpecificData_ExpectedDataAsArrayReturned(): void
    {
        // arrange
        $id = 'ID-CATEGORY-0';
        $name = 'Category new name';

        // act
        $categoryNameChanged = CategoryNameChangedMother::createWithParams([
            'id' => CategoryIdMother::create($id),
            'name' => CategoryNameMother::create($name)
        ]);
        $data = $categoryNameChanged->data();

        // assert
        $expectedData = [
            'id' => 'ID-CATEGORY-0',
            'name' => 'Category new name'
        ];
        $this->assertEquals($expectedData, $data);
    }

    public function testDataAsJson_HaveCategoryNameChangedEventWithSpecificData_ExpectedDataAsJsonReturned(): void
    {
        // arrange
        $id = 'ID-CATEGORY-0';
        $name = 'Category new name';

        // act
        $categoryNameChanged = CategoryNameChangedMother::createWithParams([
            'id' => CategoryIdMother::create($id),
            'name' => CategoryNameMother::create($name)
        ]);
        $dataAsJson = $categoryNameChanged->dataAsJson();

        // assert
        $expectedDataAsJson = '{
            "id": "ID-CATEGORY-0",
            "name": "Category new name"
        }';
        $this->assertJsonStringEqualsJsonString($expectedDataAsJson, $dataAsJson);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        FakeCalendar::destroy();
    }
}