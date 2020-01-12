<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Delivery\Api\Authenticator;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Firewall\AbstractListener;

class JwtListener extends AbstractListener
{
    private TokenService $tokenService;
    private TokenStorageInterface $tokenStorage;
    private AuthenticationManagerInterface $authenticationManager;

    public function __construct(
        TokenService $tokenService,
        TokenStorageInterface $tokenStorage,
        AuthenticationManagerInterface $authenticationManager
    ) {
        $this->tokenService = $tokenService;
        $this->tokenStorage = $tokenStorage;
        $this->authenticationManager = $authenticationManager;
    }

    /**
     * @inheritDoc
     */
    public function supports(Request $request): ?bool
    {
        if (!$request->headers->has('Authorization')) {
            return false;
        }

        $authorizationHeader = $request->headers->get('Authorization');
        return (bool)preg_match('/^Bearer .+/', $authorizationHeader);
    }

    /**
     * @inheritDoc
     */
    public function authenticate(RequestEvent $event)
    {
        $request = $event->getRequest();
        $token = $this->getToken($request);
        $jwtToken = new JwtUserToken($token);

        try {
            $authenticatedJwtToken = $this->authenticationManager->authenticate($jwtToken);
        } catch (AuthenticationException $exception) {
            $event->setResponse(
                new JsonResponse([
                    'message' => 'Unauthenticated',
                    'code' => 401
                ], Response::HTTP_UNAUTHORIZED)
            );
            return;
        }

        $this->tokenStorage->setToken($authenticatedJwtToken);
    }

    private function getToken(Request $request)
    {
        $authorizationHeader = $request->headers->get('Authorization');
        return str_replace('Bearer ', '', $authorizationHeader);
    }
}