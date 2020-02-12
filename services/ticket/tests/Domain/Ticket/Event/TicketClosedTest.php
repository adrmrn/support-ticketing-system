<?php
declare(strict_types=1);

namespace Ticket\Tests\Domain\Ticket\Event;

use Ticket\Tests\Support\TestCase;
use Ticket\Tests\Support\Helpers\Shared\Domain\FakeCalendar;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\Event\TicketClosedMother;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\TicketIdMother;

class TicketClosedTest extends TestCase
{
    public function testAggregateId_HaveSpecificCategoryIdentifier_ExpectedAggregateIdReturned(): void
    {
        // arrange
        $expectedAggregateId = 'ID-TICKET-0';

        // act
        $ticketClosed = TicketClosedMother::create(
            TicketIdMother::create($expectedAggregateId)
        );
        $aggregateId = $ticketClosed->aggregateId();

        // assert
        $this->assertEquals($expectedAggregateId, $aggregateId);
    }

    public function testOccurredOn_HaveOccurredOnDateAsDefault_ExpectedOccurredOnReturned(): void
    {
        // arrange
        $occurredOnAsString = '2020-01-01 14:45:45';
        FakeCalendar::setFakeDate($occurredOnAsString);

        // act
        $ticketClosed = TicketClosedMother::createDefault();
        $occurredOn = $ticketClosed->occurredOn();

        // assert
        $expectedOccurredOn = new \DateTimeImmutable($occurredOnAsString);
        $this->assertEquals($expectedOccurredOn, $occurredOn);
    }

    public function testVersion_HaveVersionAsDefault_ExpectedVersionOfEventReturned(): void
    {
        // act
        $ticketClosed = TicketClosedMother::createDefault();
        $version = $ticketClosed->version();

        // assert
        $expectedVersion = 0;
        $this->assertEquals($expectedVersion, $version);
    }

    public function testData_HaveTicketClosedEventWithSpecificData_ExpectedDataAsArrayReturned(): void
    {
        // arrange
        $id = 'ID-TICKET-0';

        // act
        $ticketClosed = TicketClosedMother::create(
            TicketIdMother::create($id)
        );
        $data = $ticketClosed->data();

        // assert
        $expectedData = [
            'id' => 'ID-TICKET-0'
        ];
        $this->assertEquals($expectedData, $data);
    }

    public function testDataAsJson_HaveTicketClosedEventWithSpecificData_ExpectedDataAsJsonReturned(): void
    {
        // arrange
        $id = 'ID-TICKET-0';

        // act
        $ticketClosed = TicketClosedMother::create(
            TicketIdMother::create($id)
        );
        $dataAsJson = $ticketClosed->dataAsJson();

        // assert
        $expectedDataAsJson = '{
            "id": "ID-TICKET-0"
        }';
        $this->assertJsonStringEqualsJsonString($expectedDataAsJson, $dataAsJson);
    }
}