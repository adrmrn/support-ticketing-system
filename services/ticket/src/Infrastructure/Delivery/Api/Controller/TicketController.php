<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Delivery\Api\Controller;

use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Ticket\Application\Exception\ValidationException;
use Ticket\Application\Query\GetTicket\GetTicketQuery;
use Ticket\Application\Query\GetTickets\GetTicketsQuery;
use Ticket\Application\QueryBus;
use Ticket\Application\UseCase\CreateTicket\CreateTicketCommand;
use Ticket\Application\UseCase\EditTicket\EditTicketCommand;
use Ticket\Application\UseCase\ResolveTicket\ResolveTicketCommand;
use Ticket\Domain\Ticket\TicketView;
use Ticket\Infrastructure\Delivery\Api\Authenticator\AuthenticatedUser;
use Ticket\Infrastructure\Delivery\Api\Request\Validator\CreateTicketValidator;

class TicketController extends AbstractController
{
    private CommandBus $commandBus;
    private QueryBus $queryBus;

    public function __construct(CommandBus $commandBus, QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    public function createTicket(Request $request): JsonResponse
    {
        $validator = new CreateTicketValidator($request);
        if (!$validator->isValid()) {
            throw ValidationException::withErrors($validator->errors());
        }

        /** @var AuthenticatedUser $authenticatedUser */
        $authenticatedUser = $this->getUser();
        $command = new CreateTicketCommand(
            $request->get('title'),
            $request->get('description'),
            $request->get('categoryId'),
            $authenticatedUser
        );
        $this->commandBus->handle($command);

        return new JsonResponse(null, 201);
    }

    public function editTicket(string $ticketId, Request $request): JsonResponse
    {
        $validator = new CreateTicketValidator($request);
        if (!$validator->isValid()) {
            throw ValidationException::withErrors($validator->errors());
        }

        /** @var AuthenticatedUser $authenticatedUser */
        $authenticatedUser = $this->getUser();
        $command = new EditTicketCommand(
            $request->get('ticketId'),
            $request->get('title'),
            $request->get('description'),
            $request->get('categoryId'),
            $authenticatedUser
        );
        $this->commandBus->handle($command);

        return new JsonResponse(null, 200);
    }

    public function resolveTicket(string $ticketId): JsonResponse
    {
        /** @var AuthenticatedUser $authenticatedUser */
        $authenticatedUser = $this->getUser();
        $command = new ResolveTicketCommand(
            $ticketId,
            $authenticatedUser
        );
        $this->commandBus->handle($command);

        return new JsonResponse(null, 200);
    }

    public function getTickets(): JsonResponse
    {
        /** @var AuthenticatedUser $authenticatedUser */
        $authenticatedUser = $this->getUser();
        $query = new GetTicketsQuery($authenticatedUser);
        /** @var TicketView[] $tickets */
        $tickets = $this->queryBus->handle($query);

        return new JsonResponse(
            array_map(fn(TicketView $ticket) => $ticket->toArray(), $tickets),
            200
        );
    }

    public function getTicket(string $ticketId): JsonResponse
    {
        /** @var AuthenticatedUser $authenticatedUser */
        $authenticatedUser = $this->getUser();
        $query = new GetTicketQuery($ticketId, $authenticatedUser);
        /** @var TicketView $ticket */
        $ticket = $this->queryBus->handle($query);

        return new JsonResponse(
            $ticket->toArray(),
            200
        );
    }
}