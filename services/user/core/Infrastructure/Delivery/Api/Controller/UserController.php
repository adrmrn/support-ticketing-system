<?php
declare(strict_types=1);

namespace User\Core\Infrastructure\Delivery\Api\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use User\Core\Application\Exception\ValidationException;
use User\Core\Application\Query\UserQuery;
use User\Core\Application\UseCase\RegisterCustomer\RegisterCustomer;
use Laravel\Lumen\Routing\Controller as BaseController;
use User\Core\Application\UseCase\RegisterCustomer\RegisterCustomerRequest;
use User\Core\Domain\Event\DomainEventPublisher;
use User\Core\Infrastructure\Delivery\Api\Event\RegisteredUserIdSubscriber;
use User\Core\Infrastructure\Delivery\Api\Request\Validator\RegisterUserValidator;

class UserController extends BaseController
{
    private RegisterCustomer $registerCustomer;
    private RegisterUserValidator $registerUserValidator;
    private UserQuery $userQuery;

    public function __construct(
        RegisterCustomer $registerCustomer,
        RegisterUserValidator $registerUserValidator,
        UserQuery $userQuery
    ) {
        $this->registerCustomer = $registerCustomer;
        $this->registerUserValidator = $registerUserValidator;
        $this->userQuery = $userQuery;
    }

    public function registerCustomer(Request $request): JsonResponse
    {
        if (!$this->registerUserValidator->isValid($request)) {
            throw ValidationException::withErrors(
                $this->registerUserValidator->errors()
            );
        }

        $userIdListener = $this->listenForRegisteredUserId();
        $registerCustomerRequest = new RegisterCustomerRequest(
            $request->get('email'),
            $request->get('firstName'),
            $request->get('lastName'),
            $request->get('password')
        );
        $this->registerCustomer->execute($registerCustomerRequest);

        return new JsonResponse([
            'id' => $userIdListener->userId()
        ], 201);
    }

    public function getUserById(string $userId): JsonResponse
    {
        $user = $this->userQuery->getById($userId);
        return new JsonResponse($user->toArray(), 200);
    }

    private function listenForRegisteredUserId(): RegisteredUserIdSubscriber
    {
        $listener = new RegisteredUserIdSubscriber();
        DomainEventPublisher::instance()->subscribe($listener);
        return $listener;
    }
}
