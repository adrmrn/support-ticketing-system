<?php
declare(strict_types=1);

namespace Ticket\Application\UseCase\EditTicket;

use Ticket\Application\Exception\PermissionException;
use Ticket\Domain\Category\CategoryId;
use Ticket\Domain\Category\CategoryRepository;
use Ticket\Domain\Ticket\TicketDescription;
use Ticket\Domain\Ticket\TicketId;
use Ticket\Domain\Ticket\TicketPermissionService;
use Ticket\Domain\Ticket\TicketRepository;
use Ticket\Domain\Ticket\TicketTitle;
use Ticket\Domain\User\UserId;

class EditTicketHandler
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

    public function handle(EditTicketCommand $command): void
    {
        $user = $command->executor();
        $ticket = $this->ticketRepository->getById(
            TicketId::fromString($command->ticketId())
        );
        if (!$this->ticketPermissionService->canUserManageTicket($user, $ticket)) {
            throw PermissionException::withMessage('User cannot edit that ticket.');
        }

        $category = $this->categoryRepository->getById(
            CategoryId::fromString($command->categoryId())
        );
        $ticket->changeTitle(new TicketTitle($command->title()));
        $ticket->describe(new TicketDescription($command->description()));
        $ticket->changeCategory($category->id());
    }
}