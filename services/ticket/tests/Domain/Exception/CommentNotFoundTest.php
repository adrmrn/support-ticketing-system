<?php
declare(strict_types=1);

namespace Ticket\Tests\Domain\Exception;

use Ticket\Domain\DomainException;
use Ticket\Domain\Exception\CommentNotFound;
use Ticket\Tests\Support\MotherObject\Domain\Comment\CommentIdMother;
use Ticket\Tests\Support\TestCase;

class CommentNotFoundTest extends TestCase
{
    public function testCreation_HaveCommentIdThatDoesNotExist_ReturnedExceptionHasExpectedValues(): void
    {
        // arrange
        $expectedCommentIdAsString = 'ID-COMMENT-0';
        $commentId = CommentIdMother::create($expectedCommentIdAsString);

        // act
        $exception = CommentNotFound::withCommentId($commentId);

        // assert
        $this->assertInstanceOf(DomainException::class, $exception);
        $this->assertInstanceOf(CommentNotFound::class, $exception);
        $expectedMessage = sprintf('Comment not found. Comment ID: %s', $expectedCommentIdAsString);
        $this->assertSame($expectedMessage, $exception->getMessage());
    }
}