<?php
declare(strict_types=1);

namespace Ticket\Tests\Domain\Ticket;

use PHPUnit\Framework\TestCase;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\TicketDescriptionMother;

class TicketDescriptionTest extends TestCase
{
    public function testParseToString_HaveValidDescription_ReturnedStringHasExpectedValue(): void
    {
        // arrange
        $expectedDescriptionAsString = 'Lorem ipsum dolor sit amet...';
        $description = TicketDescriptionMother::create($expectedDescriptionAsString);

        // act
        $descriptionAsString = (string)$description;

        // assert
        $this->assertSame($expectedDescriptionAsString, $descriptionAsString);
    }

    public function testParseToString_HaveMinLengthDescription_ReturnedStringHasExpectedValue(): void
    {
        // arrange
        $expectedDescriptionAsString = 'ą';
        $description = TicketDescriptionMother::create($expectedDescriptionAsString);

        // act
        $descriptionAsString = (string)$description;

        // assert
        $this->assertSame($expectedDescriptionAsString, $descriptionAsString);
    }

    public function testParseToString_HaveMaxLengthDescription_ReturnedStringHasExpectedValue(): void
    {
        // arrange
        $expectedDescriptionAsString = str_repeat('ą', 10_000);
        $description = TicketDescriptionMother::create($expectedDescriptionAsString);

        // act
        $descriptionAsString = (string)$description;

        // assert
        $this->assertSame($expectedDescriptionAsString, $descriptionAsString);
    }

    public function testCreation_HaveTooShortDescription_ThrownException(): void
    {
        // arrange
        $invalidDescription = '';

        // assert
        $this->expectException(\InvalidArgumentException::class);

        // act
        TicketDescriptionMother::create($invalidDescription);
    }

    public function testCreation_HaveTooLongDescription_ThrownException(): void
    {
        // arrange
        $invalidDescription = str_repeat('ą', 10_001);

        // assert
        $this->expectException(\InvalidArgumentException::class);

        // act
        TicketDescriptionMother::create($invalidDescription);
    }
}