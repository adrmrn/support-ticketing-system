<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Delivery\Api\Controller;

use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Ticket\Application\UseCase\AddComment\AddCommentCommand;

class CommentController
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function addComment(Request $request): JsonResponse
    {
        $command = new AddCommentCommand(
            $request->get('ticketId') ?? '',
            $request->get('content') ?? '',
            $request->get('authorId') ?? '',
        );
        $this->commandBus->handle($command);

        return new JsonResponse(null, 201);
    }
}