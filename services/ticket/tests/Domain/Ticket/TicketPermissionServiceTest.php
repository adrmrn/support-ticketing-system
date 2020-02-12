<?php
declare(strict_types=1);

namespace Ticket\Tests\Domain\Ticket;

use Ticket\Tests\Support\TestCase;
use Ticket\Domain\Ticket\TicketPermissionService;
use Ticket\Domain\User\UserRole;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\TicketMother;
use Ticket\Tests\Support\MotherObject\Domain\User\UserIdMother;
use Ticket\Tests\Support\MotherObject\Domain\User\UserMother;

class TicketPermissionServiceTest extends TestCase
{
    public function testCanUserCreateTicket_UserIsCustomer_ReturnsTrue(): void
    {
        // arrange
        $user = UserMother::createCustomer();
        $permissionService = $this->ticketPermissionService();

        // act
        $canUserCreateTicket = $permissionService->canUserCreateTicket($user);

        // assert
        $this->assertTrue($canUserCreateTicket);
    }

    public function testCanUserCreateTicket_UserIsAdmin_ReturnsFalse(): void
    {
        // arrange
        $user = UserMother::createAdmin();
        $permissionService = $this->ticketPermissionService();

        // act
        $canUserCreateTicket = $permissionService->canUserCreateTicket($user);

        // assert
        $this->assertFalse($canUserCreateTicket);
    }

    public function testCanUserManageTicket_UserIsAdmin_ReturnsTrue(): void
    {
        // arrange
        $user = UserMother::createAdmin();
        $ticket = TicketMother::createDefault();
        $permissionService = $this->ticketPermissionService();

        // act
        $canUserManageTicket = $permissionService->canUserManageTicket($user, $ticket);

        // assert
        $this->assertTrue($canUserManageTicket);
    }

    public function testCanUserManageTicket_UserIsCustomerButIsNotAuthorOfTicket_ReturnsFalse(): void
    {
        // arrange
        $ticketAuthorId = UserIdMother::create('ID-AUTHOR-1');
        $ticket = TicketMother::createWithParams([
            'author_id' => $ticketAuthorId
        ]);
        $user = UserMother::createCustomer();
        $permissionService = $this->ticketPermissionService();

        // act
        $canUserManageTicket = $permissionService->canUserManageTicket($user, $ticket);

        // assert
        $this->assertFalse($canUserManageTicket);
    }

    public function testCanUserManageTicket_UserIsCustomerAndIsAuthorOfTicket_ReturnsTrue(): void
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
        $permissionService = $this->ticketPermissionService();

        // act
        $canUserManageTicket = $permissionService->canUserManageTicket($user, $ticket);

        // assert
        $this->assertTrue($canUserManageTicket);
    }

    public function testCanUserResolveTicket_UserIsAuthorOfTicket_ReturnsTrue(): void
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
        $permissionService = $this->ticketPermissionService();

        // act
        $canUserResolveTicket = $permissionService->canUserResolveTicket($user, $ticket);

        // assert
        $this->assertTrue($canUserResolveTicket);
    }

    public function testCanUserResolveTicket_UserIsNotAuthorOfTicket_ReturnsFalse(): void
    {
        // arrange
        $ticketAuthorId = UserIdMother::create('ID-AUTHOR-1');
        $ticket = TicketMother::createWithParams([
            'author_id' => $ticketAuthorId
        ]);
        $user = UserMother::createDefault();
        $permissionService = $this->ticketPermissionService();

        // act
        $canUserResolveTicket = $permissionService->canUserResolveTicket($user, $ticket);

        // assert
        $this->assertFalse($canUserResolveTicket);
    }

    private function ticketPermissionService(): TicketPermissionService
    {
        return new TicketPermissionService();
    }
}