<?php
declare(strict_types=1);

namespace Ticket\Tests\Domain\Ticket;

use PHPUnit\Framework\TestCase;
use Ticket\Domain\Exception\LockedTicketCannotBeChanged;
use Ticket\Domain\Exception\ResolvedTicketCannotBeClosed;
use Ticket\Domain\Ticket\TicketStatus;
use Ticket\Tests\Support\Helpers\Shared\Domain\FakeCalendar;
use Ticket\Tests\Support\MotherObject\DateTimeMother;
use Ticket\Tests\Support\MotherObject\Domain\Category\CategoryIdMother;
use Ticket\Tests\Support\MotherObject\Domain\Comment\CommentContentMother;
use Ticket\Tests\Support\MotherObject\Domain\Comment\CommentIdMother;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\TicketDescriptionMother;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\TicketIdMother;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\TicketMother;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\TicketTitleMother;
use Ticket\Tests\Support\MotherObject\Domain\User\UserIdMother;

class TicketTest extends TestCase
{
    public function testCreation_HaveAllRequiredValues_CreatedTicketHasExpectedValues(): void
    {
        // arrange
        $expectedId = TicketIdMother::createDefault();
        $expectedTitle = TicketTitleMother::createDefault();
        $expectedDescription = TicketDescriptionMother::createDefault();
        $expectedCategoryId = CategoryIdMother::createDefault();
        $expectedAuthorId = UserIdMother::createDefault();
        $createdAtAsString = '2020-01-01 10:00:01';
        FakeCalendar::setFakeDate($createdAtAsString);

        // act
        $ticket = TicketMother::create(
            $expectedId,
            $expectedTitle,
            $expectedDescription,
            $expectedCategoryId,
            $expectedAuthorId
        );

        // assert
        $this->assertEquals($expectedId, $ticket->id());
        $this->assertEquals($expectedTitle, $ticket->title());
        $this->assertEquals($expectedDescription, $ticket->description());
        $this->assertEquals($expectedCategoryId, $ticket->categoryId());
        $this->assertEquals($expectedAuthorId, $ticket->authorId());
        $expectedStatus = TicketStatus::open();
        $this->assertEquals($expectedStatus, $ticket->status());
        $expectedCreatedAt = DateTimeMother::create($createdAtAsString);
        $this->assertEquals($expectedCreatedAt, $ticket->createdAt());
    }

    public function testClose_TicketHasResolvedStatusAndCannotBeChangedToClosed_ThrownException(): void
    {
        // arrange
        $ticket = TicketMother::createResolved();

        // assert
        $this->expectException(ResolvedTicketCannotBeClosed::class);

        // act
        $ticket->close();
    }

    public function testClose_TicketHasOpenStatusAndCanBeChanged_StatusChangedSuccessfully(): void
    {
        // arrange
        $ticket = TicketMother::createDefault();

        // act
        $ticket->close();
        $status = $ticket->status();

        // assert
        $expectedStatus = TicketStatus::closed();
        $this->assertEquals($expectedStatus, $status);
    }

    public function testChangeTitle_TicketIsClosedAndTitleCannotBeChanged_ThrownException(): void
    {
        // arrange
        $ticket = TicketMother::createClosed();
        $newTitle = TicketTitleMother::createDefault();

        // assert
        $this->expectException(LockedTicketCannotBeChanged::class);

        // act
        $ticket->changeTitle($newTitle);
    }

    public function testChangeTitle_TicketIsResolvedAndTitleCannotBeChanged_ThrownException(): void
    {
        // arrange
        $ticket = TicketMother::createResolved();
        $newTitle = TicketTitleMother::createDefault();

        // assert
        $this->expectException(LockedTicketCannotBeChanged::class);

        // act
        $ticket->changeTitle($newTitle);
    }

    public function testChangeTitle_HaveNewTitleAndTicketIsOpen_TitleHasBeenChanged(): void
    {
        // arrange
        $ticket = TicketMother::createDefault();
        $expectedNewTitle = TicketTitleMother::create('Lorem ipsum...');

        // act
        $ticket->changeTitle($expectedNewTitle);
        $newTitle = $ticket->title();

        // assert
        $this->assertEquals($expectedNewTitle, $newTitle);
    }

    public function testDescribe_TicketIsClosedAndDescriptionCannotBeChanged_ThrownException(): void
    {
        // arrange
        $ticket = TicketMother::createClosed();
        $newDescription = TicketDescriptionMother::createDefault();

        // assert
        $this->expectException(LockedTicketCannotBeChanged::class);

        // act
        $ticket->describe($newDescription);
    }

    public function testDescribe_TicketIsResolvedAndDescriptionCannotBeChanged_ThrownException(): void
    {
        // arrange
        $ticket = TicketMother::createResolved();
        $newDescription = TicketDescriptionMother::createDefault();

        // assert
        $this->expectException(LockedTicketCannotBeChanged::class);

        // act
        $ticket->describe($newDescription);
    }

    public function testDescribe_HaveNewDescriptionAndTicketIsOpen_DescriptionHasBeenChanged(): void
    {
        // arrange
        $ticket = TicketMother::createDefault();
        $expectedNewDescription = TicketDescriptionMother::create('Lorem ipsum dolor sit amet...');

        // act
        $ticket->describe($expectedNewDescription);
        $newDescription = $ticket->description();

        // assert
        $this->assertEquals($expectedNewDescription, $newDescription);
    }

    public function testChangeCategory_TicketIsClosedAndCategoryCannotBeChanged_ThrownException(): void
    {
        // arrange
        $ticket = TicketMother::createClosed();
        $newCategory = CategoryIdMother::createDefault();

        // assert
        $this->expectException(LockedTicketCannotBeChanged::class);

        // act
        $ticket->changeCategory($newCategory);
    }

    public function testChangeCategory_TicketIsResolvedAndCategoryCannotBeChanged_ThrownException(): void
    {
        // arrange
        $ticket = TicketMother::createResolved();
        $newCategory = CategoryIdMother::createDefault();

        // assert
        $this->expectException(LockedTicketCannotBeChanged::class);

        // act
        $ticket->changeCategory($newCategory);
    }

    public function testChangeCategory_HaveNewCategoryAndTicketIsOpen_CategoryHasBeenChanged(): void
    {
        // arrange
        $ticket = TicketMother::createDefault();
        $expectedNewCategory = CategoryIdMother::createDefault('ID-CATEGORY-0');

        // act
        $ticket->changeCategory($expectedNewCategory);
        $newCategory = $ticket->categoryId();

        // assert
        $this->assertEquals($expectedNewCategory, $newCategory);
    }

    public function testAddComment_TicketIsClosedAndCommentCannotBeAdded_ThrownException(): void
    {
        // arrange
        $ticket = TicketMother::createClosed();

        // assert
        $this->expectException(LockedTicketCannotBeChanged::class);

        // act
        $ticket->addComment(
            CommentIdMother::createDefault(),
            CommentContentMother::createDefault(),
            UserIdMother::createDefault()
        );
    }

    public function testAddComment_TicketIsResolvedAndCommentCannotBeAdded_ThrownException(): void
    {
        // arrange
        $ticket = TicketMother::createResolved();

        // assert
        $this->expectException(LockedTicketCannotBeChanged::class);

        // act
        $ticket->addComment(
            CommentIdMother::createDefault(),
            CommentContentMother::createDefault(),
            UserIdMother::createDefault()
        );
    }

    public function testAddComment_HaveAllDataToCreateCommentAndTicketIsOpen_CommentHasBeenCreated(): void
    {
        // arrange
        $expectedTicketId = TicketIdMother::createDefault();
        $ticket = TicketMother::createWithParams([
            'id' => $expectedTicketId
        ]);
        $expectedCommentId = CommentIdMother::createDefault();
        $expectedContent = CommentContentMother::createDefault();
        $expectedAuthorId = UserIdMother::createDefault();
        FakeCalendar::setFakeDate('2020-01-01 15:45:05');

        // act
        $comment = $ticket->addComment(
            $expectedCommentId,
            $expectedContent,
            $expectedAuthorId
        );
        $commentId = $comment->id();
        $content = $comment->content();
        $authorId = $comment->authorId();
        $ticketId = $comment->ticketId();
        $createdAt = $comment->createdAt();

        // assert
        $this->assertEquals($expectedCommentId, $commentId);
        $this->assertEquals($expectedContent, $content);
        $this->assertEquals($expectedAuthorId, $authorId);
        $this->assertEquals($expectedTicketId, $ticketId);
        $expectedCreatedAt = new \DateTimeImmutable('2020-01-01 15:45:05');
        $this->assertEquals($expectedCreatedAt, $createdAt);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        FakeCalendar::destroy();
    }
}