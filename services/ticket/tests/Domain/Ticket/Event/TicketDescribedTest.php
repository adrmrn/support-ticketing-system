<?php
declare(strict_types=1);

namespace Ticket\Tests\Domain\Ticket\Event;

use Ticket\Tests\Support\TestCase;
use Ticket\Tests\Support\Helpers\Shared\Domain\FakeCalendar;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\Event\TicketDescribedMother;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\TicketDescriptionMother;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\TicketIdMother;

class TicketDescribedTest extends TestCase
{
    public function testAggregateId_HaveSpecificCategoryIdentifier_ExpectedAggregateIdReturned(): void
    {
        // arrange
        $expectedAggregateId = 'ID-TICKET-0';

        // act
        $ticketDescribed = TicketDescribedMother::createWithParams([
            'id' => TicketIdMother::create($expectedAggregateId)
        ]);
        $aggregateId = $ticketDescribed->aggregateId();

        // assert
        $this->assertEquals($expectedAggregateId, $aggregateId);
    }

    public function testOccurredOn_HaveOccurredOnDateAsDefault_ExpectedOccurredOnReturned(): void
    {
        // arrange
        $occurredOnAsString = '2020-01-01 14:45:45';
        FakeCalendar::setFakeDate($occurredOnAsString);

        // act
        $ticketDescribed = TicketDescribedMother::createDefault();
        $occurredOn = $ticketDescribed->occurredOn();

        // assert
        $expectedOccurredOn = new \DateTimeImmutable($occurredOnAsString);
        $this->assertEquals($expectedOccurredOn, $occurredOn);
    }

    public function testVersion_HaveVersionAsDefault_ExpectedVersionOfEventReturned(): void
    {
        // act
        $ticketDescribed = TicketDescribedMother::createDefault();
        $version = $ticketDescribed->version();

        // assert
        $expectedVersion = 0;
        $this->assertEquals($expectedVersion, $version);
    }

    public function testData_HaveTicketDescribedEventWithSpecificData_ExpectedDataAsArrayReturned(): void
    {
        // arrange
        $id = 'ID-TICKET-0';
        $description = 'Ticket description';

        // act
        $ticketDescribed = TicketDescribedMother::createWithParams([
            'id' => TicketIdMother::create($id),
            'description' => TicketDescriptionMother::create($description)
        ]);
        $data = $ticketDescribed->data();

        // assert
        $expectedData = [
            'id' => 'ID-TICKET-0',
            'description' => 'Ticket description'
        ];
        $this->assertEquals($expectedData, $data);
    }

    public function testDataAsJson_HaveTicketDescribedEventWithSpecificData_ExpectedDataAsJsonReturned(): void
    {
        // arrange
        $id = 'ID-TICKET-0';
        $description = 'Ticket description';

        // act
        $ticketDescribed = TicketDescribedMother::createWithParams([
            'id' => TicketIdMother::create($id),
            'description' => TicketDescriptionMother::create($description)
        ]);
        $dataAsJson = $ticketDescribed->dataAsJson();

        // assert
        $expectedDataAsJson = '{
            "id": "ID-TICKET-0",
            "description": "Ticket description"
        }';
        $this->assertJsonStringEqualsJsonString($expectedDataAsJson, $dataAsJson);
    }
}