<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Delivery\Api\Controller;

use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Ticket\Application\Exception\ValidationException;
use Ticket\Application\UseCase\AddComment\AddCommentCommand;
use Ticket\Application\UseCase\EditComment\EditCommentCommand;
use Ticket\Application\UseCase\RemoveComment\RemoveCommentCommand;
use Ticket\Infrastructure\Delivery\Api\Authenticator\AuthenticatedUser;
use Ticket\Infrastructure\Delivery\Api\Request\Validator\AddCommentValidator;
use Ticket\Infrastructure\Delivery\Api\Request\Validator\EditCommentValidator;

class CommentController extends AbstractController
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function addComment(Request $request): JsonResponse
    {
        $validator = new AddCommentValidator($request);
        if (!$validator->isValid()) {
            throw ValidationException::withErrors($validator->errors());
        }

        /** @var AuthenticatedUser $authenticatedUser */
        $authenticatedUser = $this->getUser();
        $command = new AddCommentCommand(
            $request->get('ticketId'),
            $request->get('content'),
            $authenticatedUser
        );
        $this->commandBus->handle($command);

        return new JsonResponse(null, 201);
    }

    public function editComment(string $commentId, Request $request): JsonResponse
    {
        $validator = new EditCommentValidator($request);
        if (!$validator->isValid()) {
            throw ValidationException::withErrors($validator->errors());
        }

        /** @var AuthenticatedUser $authenticatedUser */
        $authenticatedUser = $this->getUser();
        $command = new EditCommentCommand(
            $commentId,
            $request->get('content'),
            $authenticatedUser
        );
        $this->commandBus->handle($command);

        return new JsonResponse(null, 201);
    }

    public function removeComment(string $commentId): JsonResponse
    {
        /** @var AuthenticatedUser $authenticatedUser */
        $authenticatedUser = $this->getUser();
        $command = new RemoveCommentCommand(
            $commentId,
            $authenticatedUser
        );
        $this->commandBus->handle($command);

        return new JsonResponse(null, 204);
    }
}