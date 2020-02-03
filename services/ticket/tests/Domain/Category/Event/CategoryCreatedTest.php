<?php
declare(strict_types=1);

namespace Ticket\Tests\Domain\Category\Event;

use PHPUnit\Framework\TestCase;
use Ticket\Tests\Support\Helpers\Shared\Domain\FakeCalendar;
use Ticket\Tests\Support\MotherObject\Domain\Category\Event\CategoryCreatedMother;
use Ticket\Tests\Support\MotherObject\Domain\Category\CategoryIdMother;
use Ticket\Tests\Support\MotherObject\Domain\Category\CategoryNameMother;

class CategoryCreatedTest extends TestCase
{
    public function testAggregateId_HaveSpecificCategoryIdentifier_ExpectedAggregateIdReturned(): void
    {
        // arrange
        $expectedAggregateId = 'ID-CATEGORY-0';

        // act
        $categoryCreated = CategoryCreatedMother::createWithParams([
            'id' => CategoryIdMother::create($expectedAggregateId)
        ]);
        $aggregateId = $categoryCreated->aggregateId();

        // assert
        $this->assertEquals($expectedAggregateId, $aggregateId);
    }

    public function testOccurredOn_HaveOccurredOnDateAsDefault_ExpectedOccurredOnReturned(): void
    {
        // arrange
        $occurredOnAsString = '2020-01-01 14:45:45';
        FakeCalendar::setFakeDate($occurredOnAsString);

        // act
        $categoryCreated = CategoryCreatedMother::createDefault();
        $occurredOn = $categoryCreated->occurredOn();

        // assert
        $expectedOccurredOn = new \DateTimeImmutable($occurredOnAsString);
        $this->assertEquals($expectedOccurredOn, $occurredOn);
    }

    public function testVersion_HaveVersionAsDefault_ExpectedVersionOfEventReturned(): void
    {
        // act
        $categoryCreated = CategoryCreatedMother::createDefault();
        $version = $categoryCreated->version();

        // assert
        $expectedVersion = 0;
        $this->assertEquals($expectedVersion, $version);
    }

    public function testData_HaveCategoryCreatedEventWithSpecificData_ExpectedDataAsArrayReturned(): void
    {
        // arrange
        $id = 'ID-CATEGORY-0';
        $name = 'Category example name';

        // act
        $categoryCreated = CategoryCreatedMother::createWithParams([
            'id' => CategoryIdMother::create($id),
            'name' => CategoryNameMother::create($name)
        ]);
        $data = $categoryCreated->data();

        // assert
        $expectedData = [
            'id' => 'ID-CATEGORY-0',
            'name' => 'Category example name'
        ];
        $this->assertEquals($expectedData, $data);
    }

    public function testDataAsJson_HaveCategoryCreatedEventWithSpecificData_ExpectedDataAsJsonReturned(): void
    {
        // arrange
        $id = 'ID-CATEGORY-0';
        $name = 'Category example name';

        // act
        $categoryCreated = CategoryCreatedMother::createWithParams([
            'id' => CategoryIdMother::create($id),
            'name' => CategoryNameMother::create($name)
        ]);
        $dataAsJson = $categoryCreated->dataAsJson();

        // assert
        $expectedDataAsJson = '{
            "id": "ID-CATEGORY-0",
            "name": "Category example name"
        }';
        $this->assertJsonStringEqualsJsonString($expectedDataAsJson, $dataAsJson);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        FakeCalendar::destroy();
    }
}