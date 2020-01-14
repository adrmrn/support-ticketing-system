<?php
declare(strict_types=1);

namespace Ticket\Application\UseCase\ResolveTicket;

use Ticket\Application\Exception\PermissionException;
use Ticket\Domain\Ticket\TicketId;
use Ticket\Domain\Ticket\TicketPermissionService;
use Ticket\Domain\Ticket\TicketRepository;
use Ticket\Domain\User\UserId;

class ResolveTicketHandler
{
    private TicketRepository $ticketRepository;
    private TicketPermissionService $ticketPermissionService;

    public function __construct(TicketRepository $ticketRepository, TicketPermissionService $ticketPermissionService)
    {
        $this->ticketRepository = $ticketRepository;
        $this->ticketPermissionService = $ticketPermissionService;
    }

    public function handle(ResolveTicketCommand $command): void
    {
        $userId = UserId::fromString($command->executorId());
        $ticketId = TicketId::fromString($command->ticketId());
        if (!$this->ticketPermissionService->canUserResolveTicket($userId, $ticketId)) {
            throw PermissionException::withMessage('User cannot resolve that ticket.');
        }

        $ticket = $this->ticketRepository->getById($ticketId);
        $ticket->resolve();
    }
}