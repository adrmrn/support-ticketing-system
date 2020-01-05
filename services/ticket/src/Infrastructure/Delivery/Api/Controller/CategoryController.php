<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Delivery\Api\Controller;

use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Ticket\Application\Exception\ValidationException;
use Ticket\Application\UseCase\CreateCategory\CreateCategoryCommand;
use Ticket\Application\UseCase\EditCategory\EditCategoryCommand;
use Ticket\Infrastructure\Delivery\Api\Request\Validator\CreateCategoryValidator;
use Ticket\Infrastructure\Delivery\Api\Request\Validator\EditCategoryValidator;

class CategoryController
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function createCategory(Request $request): JsonResponse
    {
        $validator = new CreateCategoryValidator($request->request->all());
        if (!$validator->isValid()) {
            throw ValidationException::withErrors($validator->errors());
        }

        $command = new CreateCategoryCommand(
            $request->get('name')
        );
        $this->commandBus->handle($command);

        return new JsonResponse(null, 201);
    }

    public function editCategory(string $categoryId, Request $request): JsonResponse
    {
        $data = $request->request->all();
        $data['id'] = $categoryId;
        $validator = new EditCategoryValidator($data);
        if (!$validator->isValid()) {
            throw ValidationException::withErrors($validator->errors());
        }

        $command = new EditCategoryCommand(
            $categoryId,
            $request->get('name')
        );
        $this->commandBus->handle($command);

        return new JsonResponse(null, 201);
    }
}