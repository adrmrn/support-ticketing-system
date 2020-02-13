<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Event\EventListener\Symfony;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Ticket\Application\Exception\PermissionException;
use Ticket\Application\Exception\ValidationException;
use Ticket\Domain\DomainException;
use Ticket\Domain\NotFoundException;

class ExceptionSubscriber implements EventSubscriberInterface
{
    private string $appEnv;

    public function __construct(string $appEnv)
    {
        $this->appEnv = $appEnv;
    }

    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return [
            KernelEvents::EXCEPTION => [
                ['permissionException', 30],
                ['domainException', 20],
                ['validationException', 10],
                ['unhandledException', 0]
            ],
        ];
    }

    public function permissionException(ExceptionEvent $event): void
    {
        $thrownException = $event->getThrowable();
        if ($thrownException instanceof PermissionException) {
            $response = new JsonResponse(
                [
                    'message' => $thrownException->getMessage(),
                    'code' => 403
                ],
                403
            );
            $event->setResponse($response);
        }
    }

    public function domainException(ExceptionEvent $event): void
    {
        $thrownException = $event->getThrowable();
        if ($thrownException instanceof NotFoundException) {
            $response = new JsonResponse(
                [
                    'message' => $thrownException->getMessage(),
                    'code' => 404
                ],
                404
            );
            $event->setResponse($response);
            return;
        }

        if ($thrownException instanceof DomainException) {
            $response = new JsonResponse(
                [
                    'message' => $thrownException->getMessage(),
                    'code' => 422
                ],
                422
            );
            $event->setResponse($response);
        }
    }

    public function validationException(ExceptionEvent $event): void
    {
        $thrownException = $event->getThrowable();
        if ($thrownException instanceof ValidationException) {
            $response = new JsonResponse(
                [
                    'message' => $thrownException->getMessage(),
                    'code' => 400,
                    'errors' => $thrownException->errors()
                ],
                400
            );
            $event->setResponse($response);
        }
    }

    public function unhandledException(ExceptionEvent $event): void
    {
        if ($this->appEnv === 'dev') {
            return;
        }

        $thrownException = $event->getThrowable();
        if ($thrownException instanceof \Exception) {
            $response = new JsonResponse(
                [
                    'message' => 'Internal Server Error',
                    'code' => 500
                ],
                500
            );
            $event->setResponse($response);
        }
    }
}