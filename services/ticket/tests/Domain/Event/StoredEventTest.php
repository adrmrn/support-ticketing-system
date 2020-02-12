<?php
declare(strict_types=1);

namespace Ticket\Tests\Domain\Event;

use Ticket\Tests\Support\MotherObject\DateTimeMother;
use Ticket\Tests\Support\MotherObject\Domain\Event\StoredEventMother;
use Ticket\Tests\Support\TestCase;

class StoredEventTest extends TestCase
{
    public function testCreation_HaveAllRequiredData_StoredEventHasExpectedValues(): void
    {
        // arrange
        $expectedEventId = 1;
        $expectedEventName = 'Event name';
        $expectedAggregateId = 'ID-AGGREGATE-0';
        $expectedOccurredOn = DateTimeMother::create('2020-01-01 10:00:30');
        $expectedVersion = 0;
        $expectedDataAsJson = '{"id": "ID-AGGREGATE-0"}';

        // act
        $storedEvent = StoredEventMother::create(
            $expectedEventId,
            $expectedEventName,
            $expectedAggregateId,
            $expectedOccurredOn,
            $expectedVersion,
            $expectedDataAsJson
        );

        // assert
        $this->assertSame($expectedEventId, $storedEvent->eventId());
        $this->assertSame($expectedEventName, $storedEvent->eventName());
        $this->assertSame($expectedAggregateId, $storedEvent->aggregateId());
        $this->assertEquals($expectedOccurredOn, $storedEvent->occurredOn());
        $this->assertSame($expectedVersion, $storedEvent->version());
        $this->assertSame($expectedDataAsJson, $storedEvent->dataAsJson());
    }
}