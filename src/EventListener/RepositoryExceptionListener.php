<?php
declare(strict_types=1);


namespace App\EventListener;


use App\Exception\RepositoryExceptionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class RepositoryExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getException();

        if (!$exception instanceof RepositoryExceptionInterface) {
            return;
        }

        $response = new JsonResponse([
            'message' => $exception->getMessage()
        ], 400);

        $event->setResponse($response);
    }
}