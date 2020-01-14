<?php
declare(strict_types=1);

namespace User\Core\Infrastructure\Middleware;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use User\Core\Infrastructure\Delivery\Api\Authenticator\TokenService;

class UserJwtAuthenticationMiddleware
{
    private TokenService $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    public function handle(Request $request, \Closure $next)
    {
        if (!$request->hasHeader('Authorization')) {
            return $this->unauthenticatedResponse('Authorization header missing.');
        }

        $authorizationHeader = $request->header('Authorization');
        if (!$this->hasAuthorizationHeaderAnExpectedFormat($authorizationHeader)) {
            return $this->unauthenticatedResponse('Authorization header is malformed.');
        }

        $token = $this->getTokenFromAuthorizationHeader($authorizationHeader);
        if (!$this->tokenService->isTokenValid($token)) {
            return $this->unauthenticatedResponse('Token is invalid.');
        }

        $authenticatedUser = $this->tokenService->decodeUserFromToken($token);
        $request->setUserResolver(function() use ($authenticatedUser) {
            return $authenticatedUser;
        });
        return $next($request);
    }

    private function hasAuthorizationHeaderAnExpectedFormat(string $authorizationHeader): bool
    {
        return (bool)preg_match('/^Bearer .+/', $authorizationHeader);
    }

    public function getTokenFromAuthorizationHeader(string $authorizationHeader): string
    {
        return str_replace('Bearer ', '', $authorizationHeader);
    }

    private function unauthenticatedResponse(string $message): JsonResponse
    {
        return new JsonResponse([
            'message' => sprintf('Unauthenticated. %s', $message),
            'code' => 401
        ], 401);
    }
}
