<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Delivery\Api\Controller;

use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Ticket\Application\Exception\ValidationException;
use Ticket\Application\Query\GetCategories\GetCategoriesQuery;
use Ticket\Application\UseCase\CreateCategory\CreateCategoryCommand;
use Ticket\Application\UseCase\EditCategory\EditCategoryCommand;
use Ticket\Application\UseCase\RemoveCategory\RemoveCategoryCommand;
use Ticket\Domain\Category\CategoryView;
use Ticket\Infrastructure\Delivery\Api\Authenticator\AuthenticatedUser;
use Ticket\Infrastructure\Delivery\Api\Request\Validator\CreateCategoryValidator;
use Ticket\Application\QueryBus;

class CategoryController extends AbstractController
{
    private CommandBus $commandBus;
    private QueryBus $queryBus;

    public function __construct(CommandBus $commandBus, QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
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
            $authenticatedUser
        );
        $this->commandBus->handle($command);

        return new JsonResponse(null, 201);
    }

    public function getCategories(Request $request): JsonResponse
    {
        $query = new GetCategoriesQuery();
        $categories = $this->queryBus->handle($query);

        return new JsonResponse(
            array_map(
                fn(CategoryView $category) => $category->toArray(),
                $categories
            ),
            200
        );
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
            $authenticatedUser
        );
        $this->commandBus->handle($command);

        return new JsonResponse(null, 201);
    }

    public function removeCategory(string $categoryId, Request $request): JsonResponse
    {
        /** @var AuthenticatedUser $authenticatedUser */
        $authenticatedUser = $this->getUser();
        $command = new RemoveCategoryCommand($categoryId, $authenticatedUser);
        $this->commandBus->handle($command);

        return new JsonResponse(null, 204);
    }
}