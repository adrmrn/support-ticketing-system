<?php
declare(strict_types=1);

namespace User\Core\Infrastructure\Delivery\Rpc\Controller;

use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller as BaseController;

class UserController extends BaseController
{
    public function getUserById(string $userId): JsonResponse
    {
        // TODO: implement logic
        return new JsonResponse([
            'id' => $userId,
            'firstName' => 'John',
            'lastName' => 'Doe',
            'role' => 'admin'
        ], 200);
    }
}
