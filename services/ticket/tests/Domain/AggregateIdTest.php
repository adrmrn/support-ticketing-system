<?php
declare(strict_types=1);

namespace Ticket\Tests\Domain;

use Ticket\Tests\Support\Helpers\Domain\FakeAggregateId;
use Ticket\Tests\Support\TestCase;

class AggregateIdTest extends TestCase
{
    public function testFromString_HaveIdentifierAsString_AggregateIdHasExpectedValue(): void
    {
        // arrange
        $expectedAggregateIdAsString = 'ID-AGGREGATE-0';

        // act
        $aggregateId = FakeAggregateId::fromString($expectedAggregateIdAsString);

        // assert
        $this->assertSame($expectedAggregateIdAsString, (string)$aggregateId);
    }

    public function testFromString_HaveEmptyIdentifier_ThrowsException(): void
    {
        // arrange
        $invalidIdentifier = '';

        // assert
        $this->expectException(\InvalidArgumentException::class);

        // act
        FakeAggregateId::fromString($invalidIdentifier);
    }

    public function testEquals_CompareTwoSameIdentifiers_ReturnsTrue(): void
    {
        // arrange
        $aggregateIdOne = FakeAggregateId::fromString('ID-AGGREGATE-0');
        $aggregateIdTwo = FakeAggregateId::fromString('ID-AGGREGATE-0');

        // act
        $equals = $aggregateIdOne->equals($aggregateIdTwo);

        // assert
        $this->assertTrue($equals);
    }
}