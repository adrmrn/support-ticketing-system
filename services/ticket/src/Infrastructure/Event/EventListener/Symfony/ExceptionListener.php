<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Event\EventListener\Symfony;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Ticket\Application\Exception\ValidationException;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
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
}