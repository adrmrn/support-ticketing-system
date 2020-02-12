<?php
declare(strict_types=1);

namespace Ticket\Tests\Domain\Category\Event;

use Ticket\Tests\Support\TestCase;
use Ticket\Tests\Support\Helpers\Shared\Domain\FakeCalendar;
use Ticket\Tests\Support\MotherObject\Domain\Category\CategoryIdMother;
use Ticket\Tests\Support\MotherObject\Domain\Category\Event\CategoryRemovedMother;

class CategoryRemovedTest extends TestCase
{
    public function testAggregateId_HaveSpecificCategoryIdentifier_ExpectedAggregateIdReturned(): void
    {
        // arrange
        $expectedAggregateId = 'ID-CATEGORY-0';

        // act
        $categoryRemoved = CategoryRemovedMother::create(
            CategoryIdMother::create($expectedAggregateId)
        );
        $aggregateId = $categoryRemoved->aggregateId();

        // assert
        $this->assertEquals($expectedAggregateId, $aggregateId);
    }

    public function testOccurredOn_HaveOccurredOnDateAsDefault_ExpectedOccurredOnReturned(): void
    {
        // arrange
        $occurredOnAsString = '2020-01-01 14:45:45';
        FakeCalendar::setFakeDate($occurredOnAsString);

        // act
        $categoryRemoved = CategoryRemovedMother::createDefault();
        $occurredOn = $categoryRemoved->occurredOn();

        // assert
        $expectedOccurredOn = new \DateTimeImmutable($occurredOnAsString);
        $this->assertEquals($expectedOccurredOn, $occurredOn);
    }

    public function testVersion_HaveVersionAsDefault_ExpectedVersionOfEventReturned(): void
    {
        // act
        $categoryRemoved = CategoryRemovedMother::createDefault();
        $version = $categoryRemoved->version();

        // assert
        $expectedVersion = 0;
        $this->assertEquals($expectedVersion, $version);
    }

    public function testData_HaveCategoryRemovedEventWithSpecificData_ExpectedDataAsArrayReturned(): void
    {
        // arrange
        $id = 'ID-CATEGORY-0';

        // act
        $categoryRemoved = CategoryRemovedMother::create(
            CategoryIdMother::create($id)
        );
        $data = $categoryRemoved->data();

        // assert
        $expectedData = [
            'id' => 'ID-CATEGORY-0'
        ];
        $this->assertEquals($expectedData, $data);
    }

    public function testDataAsJson_HaveCategoryRemovedEventWithSpecificData_ExpectedDataAsJsonReturned(): void
    {
        // arrange
        $id = 'ID-CATEGORY-0';

        // act
        $categoryRemoved = CategoryRemovedMother::create(
            CategoryIdMother::create($id)
        );
        $dataAsJson = $categoryRemoved->dataAsJson();

        // assert
        $expectedDataAsJson = '{
            "id": "ID-CATEGORY-0"
        }';
        $this->assertJsonStringEqualsJsonString($expectedDataAsJson, $dataAsJson);
    }
}