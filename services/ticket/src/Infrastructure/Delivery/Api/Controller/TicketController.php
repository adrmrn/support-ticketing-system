<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Delivery\Api\Controller;

use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Ticket\Application\Exception\ValidationException;
use Ticket\Application\UseCase\CreateTicket\CreateTicketCommand;
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
        $validator = new CreateTicketValidator($request->request->all());
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
}