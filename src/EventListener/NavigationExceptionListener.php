<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class NavigationExceptionListener {

    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $response = new Response();
            
        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());

            $message = sprintf(
                "<body>
                    <main class='container row-cols-1 justify-content-center'>
                    <h2>Message d'erreur</h2>
                    <p>%s</p>
        
                    <h3>Code d'erreur</h3>
                    <p>". $exception->getStatusCode()."</p>
                    </main>
                </body>",

                $exception->getMessage()
            );
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $message = sprintf(
                "<body>
                    <main class='container row-cols-1 justify-content-center'>
                    <h2>Message d'erreur</h2>
                    <p>%s</p>
        
                    <h3>Code d'erreur</h3>
                    <p>%s</p>
                    </main>
                </body>",

                $exception->getMessage(),
                $exception->getCode()
            );
        }
        
        $response->setContent($message);

        $event->setResponse($response);
    }
}