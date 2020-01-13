<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Delivery\Api\Controller;

use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Ticket\Application\Exception\ValidationException;
use Ticket\Application\UseCase\CreateCategory\CreateCategoryCommand;
use Ticket\Application\UseCase\EditCategory\EditCategoryCommand;
use Ticket\Infrastructure\Delivery\Api\Authenticator\AuthenticatedUser;
use Ticket\Infrastructure\Delivery\Api\Request\Validator\CreateCategoryValidator;

class CategoryController extends AbstractController
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function createCategory(Request $request): JsonResponse
    {
        $validator = new CreateCategoryValidator($request);
        if (!$validator->isValid()) {
            throw ValidationException::withErrors($validator->errors());
        }

        /** @var AuthenticatedUser $authenticatedUser */
        $authenticatedUser = $this->getUser();
        $command = new CreateCategoryCommand(
            $request->get('name'),
            (string)$authenticatedUser->id()
        );
        $this->commandBus->handle($command);

        return new JsonResponse(null, 201);
    }

    public function editCategory(string $categoryId, Request $request): JsonResponse
    {
        $validator = new CreateCategoryValidator($request);
        if (!$validator->isValid()) {
            throw ValidationException::withErrors($validator->errors());
        }

        /** @var AuthenticatedUser $authenticatedUser */
        $authenticatedUser = $this->getUser();
        $command = new EditCategoryCommand(
            $categoryId,
            $request->get('name'),
            (string)$authenticatedUser->id()
        );
        $this->commandBus->handle($command);

        return new JsonResponse(null, 201);
    }
}