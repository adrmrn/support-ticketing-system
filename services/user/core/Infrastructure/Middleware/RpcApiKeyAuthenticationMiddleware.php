<?php
declare(strict_types=1);

namespace User\Core\Infrastructure\Middleware;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RpcApiKeyAuthenticationMiddleware
{
    private const RPC_AUTH_HEADER = 'X-RPC-AUTH';

    private string $rpcAuthKey;

    public function __construct(string $rpcAuthKey)
    {
        $this->rpcAuthKey = $rpcAuthKey;
    }

    public function handle(Request $request, \Closure $next)
    {
        if (!$request->headers->has(self::RPC_AUTH_HEADER)) {
            return $this->unauthenticatedResponse(
                sprintf('%s key missing.', self::RPC_AUTH_HEADER)
            );
        }

        if ($this->rpcAuthKey !== $request->headers->get(self::RPC_AUTH_HEADER)) {
            return $this->unauthenticatedResponse(
                sprintf('Invalid %s key.', self::RPC_AUTH_HEADER)
            );
        }

        return $next($request);
    }

    private function unauthenticatedResponse(string $message): JsonResponse
    {
        return new JsonResponse([
            'message' => sprintf('Unauthenticated. %s', $message),
            'code' => 401
        ], 401);
    }
}
