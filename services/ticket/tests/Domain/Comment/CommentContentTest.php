<?php
declare(strict_types=1);

namespace Ticket\Tests\Domain\Comment;

use Ticket\Tests\Support\TestCase;
use Ticket\Tests\Support\MotherObject\Domain\Comment\CommentContentMother;

class CommentContentTest extends TestCase
{
    public function testCreation_HaveTooShortContent_ThrownException(): void
    {
        // arrange
        $invalidContent = '';

        // assert
        $this->expectException(\InvalidArgumentException::class);

        // act
        CommentContentMother::create($invalidContent);
    }

    public function testCreation_HaveTooLongContent_ThrownException(): void
    {
        // arrange
        $invalidContent = str_repeat('ą', 10_001);

        // assert
        $this->expectException(\InvalidArgumentException::class);

        // act
        CommentContentMother::create($invalidContent);
    }

    public function testParseToString_HaveValidContent_ContentHasBeenParsed(): void
    {
        // arrange
        $expectedContentAsString = 'Lorem ipsum dolor sit amet...';
        $content = CommentContentMother::create($expectedContentAsString);

        // act
        $contentAsString = (string)$content;

        // assert
        $this->assertSame($expectedContentAsString, $contentAsString);
    }

    public function testParseToString_HaveMinLengthContent_ContentHasBeenParsed(): void
    {
        // arrange
        $expectedContentAsString = 'ą';
        $content = CommentContentMother::create($expectedContentAsString);

        // act
        $contentAsString = (string)$content;

        // assert
        $this->assertSame($expectedContentAsString, $contentAsString);
    }

    public function testParseToString_HaveMaxLengthContent_ContentHasBeenParsed(): void
    {
        // arrange
        $expectedContentAsString = str_repeat('ą', 10_000);
        $content = CommentContentMother::create($expectedContentAsString);

        // act
        $contentAsString = (string)$content;

        // assert
        $this->assertSame($expectedContentAsString, $contentAsString);
    }

    public function testEquals_HaveTwoSameContents_ReturnsTrue(): void
    {
        // arrange
        $contentOne = CommentContentMother::create('Same content');
        $contentTwo = CommentContentMother::create('Same content');

        // act
        $equals = $contentOne->equals($contentTwo);

        // assert
        $this->assertTrue($equals);
    }

    public function testEquals_HaveTwoDifferentContents_ReturnsFalse(): void
    {
        // arrange
        $contentOne = CommentContentMother::create('Content one');
        $contentTwo = CommentContentMother::create('Content two');

        // act
        $equals = $contentOne->equals($contentTwo);

        // assert
        $this->assertFalse($equals);
    }
}