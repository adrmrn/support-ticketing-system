<?php
declare(strict_types=1);

namespace Ticket\Tests\Domain\Ticket\Event;

use Ticket\Tests\Support\TestCase;
use Ticket\Tests\Support\Helpers\Shared\Domain\FakeCalendar;
use Ticket\Tests\Support\MotherObject\Domain\Category\CategoryIdMother;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\Event\TicketCategoryChangedMother;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\TicketIdMother;

class TicketCategoryChangedTest extends TestCase
{
    public function testAggregateId_HaveSpecificCategoryIdentifier_ExpectedAggregateIdReturned(): void
    {
        // arrange
        $expectedAggregateId = 'ID-TICKET-0';

        // act
        $ticketCategoryChanged = TicketCategoryChangedMother::createWithParams([
            'id' => TicketIdMother::create($expectedAggregateId)
        ]);
        $aggregateId = $ticketCategoryChanged->aggregateId();

        // assert
        $this->assertEquals($expectedAggregateId, $aggregateId);
    }

    public function testOccurredOn_HaveOccurredOnDateAsDefault_ExpectedOccurredOnReturned(): void
    {
        // arrange
        $occurredOnAsString = '2020-01-01 14:45:45';
        FakeCalendar::setFakeDate($occurredOnAsString);

        // act
        $ticketCategoryChanged = TicketCategoryChangedMother::createDefault();
        $occurredOn = $ticketCategoryChanged->occurredOn();

        // assert
        $expectedOccurredOn = new \DateTimeImmutable($occurredOnAsString);
        $this->assertEquals($expectedOccurredOn, $occurredOn);
    }

    public function testVersion_HaveVersionAsDefault_ExpectedVersionOfEventReturned(): void
    {
        // act
        $ticketCategoryChanged = TicketCategoryChangedMother::createDefault();
        $version = $ticketCategoryChanged->version();

        // assert
        $expectedVersion = 0;
        $this->assertEquals($expectedVersion, $version);
    }

    public function testData_HaveTicketCategoryChangedEventWithSpecificData_ExpectedDataAsArrayReturned(): void
    {
        // arrange
        $id = 'ID-TICKET-0';
        $categoryId = 'ID-CATEGORY-0';

        // act
        $ticketCategoryChanged = TicketCategoryChangedMother::createWithParams([
            'id' => TicketIdMother::create($id),
            'category_id' => CategoryIdMother::create($categoryId)
        ]);
        $data = $ticketCategoryChanged->data();

        // assert
        $expectedData = [
            'id' => 'ID-TICKET-0',
            'categoryId' => 'ID-CATEGORY-0'
        ];
        $this->assertEquals($expectedData, $data);
    }

    public function testDataAsJson_HaveTicketCategoryChangedEventWithSpecificData_ExpectedDataAsJsonReturned(): void
    {
        // arrange
        $id = 'ID-TICKET-0';
        $categoryId = 'ID-CATEGORY-0';

        // act
        $ticketCategoryChanged = TicketCategoryChangedMother::createWithParams([
            'id' => TicketIdMother::create($id),
            'category_id' => CategoryIdMother::create($categoryId)
        ]);
        $dataAsJson = $ticketCategoryChanged->dataAsJson();

        // assert
        $expectedDataAsJson = '{
            "id": "ID-TICKET-0",
            "categoryId": "ID-CATEGORY-0"
        }';
        $this->assertJsonStringEqualsJsonString($expectedDataAsJson, $dataAsJson);
    }
}