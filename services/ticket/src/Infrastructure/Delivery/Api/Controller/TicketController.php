<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Delivery\Api\Controller;

use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Ticket\Application\Exception\ValidationException;
use Ticket\Application\UseCase\CreateTicket\CreateTicketCommand;
use Ticket\Application\UseCase\EditTicket\EditTicketCommand;
use Ticket\Application\UseCase\ResolveTicket\ResolveTicketCommand;
use Ticket\Infrastructure\Delivery\Api\Request\Validator\CreateTicketValidator;

class TicketController
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function createTicket(Request $request): JsonResponse
    {
        $validator = new CreateTicketValidator($request);
        if (!$validator->isValid()) {
            throw ValidationException::withErrors($validator->errors());
        }

        $command = new CreateTicketCommand(
            $request->get('title'),
            $request->get('description'),
            $request->get('categoryId'),
            $request->get('authorId')
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

        $command = new EditTicketCommand(
            $request->get('ticketId'),
            $request->get('title'),
            $request->get('description'),
            $request->get('categoryId')
        );
        $this->commandBus->handle($command);

        return new JsonResponse(null, 201);
    }

    public function resolveTicket(string $ticketId): JsonResponse
    {
        $command = new ResolveTicketCommand($ticketId);
        $this->commandBus->handle($command);

        return new JsonResponse(null, 200);
    }
}