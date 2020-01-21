<?php
declare(strict_types=1);

namespace Ticket\Tests\Domain\Comment;

use PHPUnit\Framework\TestCase;
use Ticket\Domain\Comment\CommentPermissionService;
use Ticket\Domain\User\UserRole;
use Ticket\Tests\Support\MotherObject\Domain\Comment\CommentMother;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\TicketMother;
use Ticket\Tests\Support\MotherObject\Domain\User\UserIdMother;
use Ticket\Tests\Support\MotherObject\Domain\User\UserMother;

class CommentPermissionServiceTest extends TestCase
{
    public function testCanUserCommentTicket_UserIsAdmin_ReturnsTrue(): void
    {
        // arrange
        $user = UserMother::createAdmin();
        $ticket = TicketMother::createDefault();
        $permissionService = $this->commentPermissionService();

        // act
        $canUserCommentTicket = $permissionService->canUserCommentTicket($user, $ticket);

        // assert
        $this->assertTrue($canUserCommentTicket);
    }

    public function testCanUserCommentTicket_UserIsCustomerButIsNotAuthorOfTicket_ReturnsFalse(): void
    {
        // arrange
        $user = UserMother::createCustomer();
        $ticketAuthorId = UserIdMother::create('ID-AUTHOR-1');
        $ticket = TicketMother::createWithParams([
            'author_id' => $ticketAuthorId
        ]);
        $permissionService = $this->commentPermissionService();

        // act
        $canUserCommentTicket = $permissionService->canUserCommentTicket($user, $ticket);

        // assert
        $this->assertFalse($canUserCommentTicket);
    }

    public function testCanUserCommentTicket_UserIsCustomerAndIsAuthorOfTicket_ReturnsTrue(): void
    {
        // arrange
        $ticketAuthorId = UserIdMother::create('ID-AUTHOR-1');
        $ticket = TicketMother::createWithParams([
            'author_id' => $ticketAuthorId
        ]);
        $user = UserMother::createWithParams([
            'id' => $ticketAuthorId,
            'role' => UserRole::customer()
        ]);
        $permissionService = $this->commentPermissionService();

        // act
        $canUserCommentTicket = $permissionService->canUserCommentTicket($user, $ticket);

        // assert
        $this->assertTrue($canUserCommentTicket);
    }

    public function testCanUserManageComment_UserIsNotAuthorOfComment_ReturnsFalse(): void
    {
        // arrange
        $commentAuthorId = UserIdMother::create('ID-AUTHOR-1');
        $comment = CommentMother::createWithParams([
            'author_id' => $commentAuthorId
        ]);
        $user = UserMother::createDefault();
        $permissionService = $this->commentPermissionService();

        // act
        $canUserManageComment = $permissionService->canUserManageComment($user, $comment);

        // assert
        $this->assertFalse($canUserManageComment);
    }

    public function testCanUserManageComment_UserIsAuthorOfComment_ReturnsTrue(): void
    {
        // arrange
        $commentAuthorId = UserIdMother::create('ID-AUTHOR-1');
        $comment = CommentMother::createWithParams([
            'author_id' => $commentAuthorId
        ]);
        $user = UserMother::createWithParams([
            'id' => $commentAuthorId
        ]);
        $permissionService = $this->commentPermissionService();

        // act
        $canUserManageComment = $permissionService->canUserManageComment($user, $comment);

        // assert
        $this->assertTrue($canUserManageComment);
    }

    private function commentPermissionService(): CommentPermissionService
    {
        return new CommentPermissionService();
    }
}