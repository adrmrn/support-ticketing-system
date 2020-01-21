<?php
declare(strict_types=1);

namespace Ticket\Application\UseCase\CreateTicket;

use Ticket\Application\Exception\PermissionException;
use Ticket\Domain\Category\CategoryId;
use Ticket\Domain\Category\CategoryRepository;
use Ticket\Domain\Ticket\Ticket;
use Ticket\Domain\Ticket\TicketDescription;
use Ticket\Domain\Ticket\TicketId;
use Ticket\Domain\Ticket\TicketPermissionService;
use Ticket\Domain\Ticket\TicketRepository;
use Ticket\Domain\Ticket\TicketTitle;
use Ticket\Domain\User\UserId;

class CreateTicketHandler
{
    private TicketRepository $ticketRepository;
    private CategoryRepository $categoryRepository;
    private TicketPermissionService $ticketPermissionService;

    public function __construct(
        TicketRepository $ticketRepository,
        CategoryRepository $categoryRepository,
        TicketPermissionService $ticketPermissionService
    ) {
        $this->ticketRepository = $ticketRepository;
        $this->categoryRepository = $categoryRepository;
        $this->ticketPermissionService = $ticketPermissionService;
    }

    public function handle(CreateTicketCommand $command): void
    {
        $user = $command->author();
        if (!$this->ticketPermissionService->canUserCreateTicket($user)) {
            throw PermissionException::withMessage('User cannot create ticket.');
        }

        $category = $this->categoryRepository->getById(
            CategoryId::fromString($command->categoryId())
        );
        $ticket = new Ticket(
            $this->ticketRepository->nextIdentity(),
            new TicketTitle($command->title()),
            new TicketDescription($command->description()),
            $category->id(),
            $user->id()
        );
        $this->ticketRepository->add($ticket);
    }
}