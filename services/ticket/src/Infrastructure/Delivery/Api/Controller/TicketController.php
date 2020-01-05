<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Delivery\Api\Controller;

use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Ticket\Application\UseCase\CreateTicket\CreateTicketCommand;

class TicketController
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function createTicket(Request $request): JsonResponse
    {
        $command = new CreateTicketCommand(
            $request->get('title') ?? '',
            $request->get('description') ?? '',
            $request->get('categoryId') ?? '',
            $request->get('authorId') ?? ''
        );
        $this->commandBus->handle($command);

        return new JsonResponse(null, 201);
    }
}