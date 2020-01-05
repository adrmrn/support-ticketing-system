<?php
declare(strict_types=1);

namespace Ticket\Tests\Domain\Comment;

use PHPUnit\Framework\TestCase;
use Ticket\Tests\Support\Helpers\Shared\Domain\FakeCalendar;
use Ticket\Tests\Support\MotherObject\Domain\Comment\CommentContentMother;
use Ticket\Tests\Support\MotherObject\Domain\Comment\CommentIdMother;
use Ticket\Tests\Support\MotherObject\Domain\Comment\CommentMother;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\TicketIdMother;
use Ticket\Tests\Support\MotherObject\Domain\User\UserIdMother;

class CommentTest extends TestCase
{
    public function testCreation_HaveAllRequiredValues_CreatedCommentHasExpectedValues(): void
    {
        // arrange
        $expectedCommentId = CommentIdMother::createDefault();
        $expectedContent = CommentContentMother::createDefault();
        $expectedAuthorId = UserIdMother::createDefault();
        $expectedTicketId = TicketIdMother::createDefault();
        FakeCalendar::setFakeDate('2020-01-01 10:00:10');

        // act
        $comment = CommentMother::create(
            $expectedCommentId,
            $expectedContent,
            $expectedAuthorId,
            $expectedTicketId
        );

        // assert
        $this->assertEquals($expectedCommentId, $comment->id());
        $this->assertEquals($expectedContent, $comment->content());
        $this->assertEquals($expectedAuthorId, $comment->authorId());
        $this->assertEquals($expectedTicketId, $comment->ticketId());
        $expectedCreatedAt = new \DateTimeImmutable('2020-01-01 10:00:10');
        $this->assertEquals($expectedCreatedAt, $comment->createdAt());
    }

    public function testEdit_HaveNewContent_ContentHasBeenEdited(): void
    {
        // arrange
        $oldContent = CommentContentMother::create('Old comment content');
        $comment = CommentMother::createWithParams([
            'content' => $oldContent
        ]);
        $expectedNewContent = CommentContentMother::create('New comment content');

        // act
        $comment->edit($expectedNewContent);

        // assert
        $this->assertEquals($expectedNewContent, $comment->content());
    }

    public function tearDown(): void
    {
        parent::tearDown();

        FakeCalendar::destroy();
    }
}