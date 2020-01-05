<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Delivery\Api\Controller;

use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Ticket\Application\UseCase\CreateCategory\CreateCategoryCommand;

class CategoryController
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function createCategory(Request $request): JsonResponse
    {
        $command = new CreateCategoryCommand(
            $request->get('name') ?? ''
        );
        $this->commandBus->handle($command);

        return new JsonResponse(null, 201);
    }
}