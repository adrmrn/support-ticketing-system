<?php
declare(strict_types=1);

namespace User\Core\Infrastructure\Delivery\Rpc\Controller;

use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller as BaseController;
use User\Core\Application\Query\UserQuery;

class UserController extends BaseController
{
    private UserQuery $userQuery;

    public function __construct(UserQuery $userQuery)
    {
        $this->userQuery = $userQuery;
    }

    public function getUserById(string $userId): JsonResponse
    {
        $user = $this->userQuery->getById($userId);
        return new JsonResponse($user->toArray(), 200);
    }
}
