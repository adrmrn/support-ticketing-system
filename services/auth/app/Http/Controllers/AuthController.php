<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\CredentialsNotFound;
use App\Exceptions\InvalidCredentialsProvided;
use App\UseCases\AuthorizeUser\AuthorizeUser;
use App\UseCases\AuthorizeUser\AuthorizeUserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class AuthController extends BaseController
{
    private AuthorizeUser $authorizeUser;

    public function __construct(AuthorizeUser $authorizeUser)
    {
        $this->authorizeUser = $authorizeUser;
    }

    public function login(Request $request): JsonResponse
    {
        $this->validate($request, [
            'email' => ['required', 'email'],
            'password' => ['required', 'string']
        ]);

        $authorizeUserRequest = new AuthorizeUserRequest(
            $request->get('email'),
            $request->get('password')
        );

        try {
            $token = $this->authorizeUser->execute($authorizeUserRequest);
        } catch (CredentialsNotFound | InvalidCredentialsProvided $exception) {
            return new JsonResponse(null, 401);
        }

        return new JsonResponse([
            'token' => (string)$token
        ], 201);
    }
}
