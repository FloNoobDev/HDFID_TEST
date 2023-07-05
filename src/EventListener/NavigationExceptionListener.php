<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class NavigationExceptionListener
{

    public function __construct(
        private Environment $twig
    ) {
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        if (!$exception instanceof NotFoundHttpException) {
            return;
        } else {
            $codeError = $exception->getStatusCode();
        }

        $contentPage = $this->twig->render('exception/errorException.html.twig', [
            'codeError' => $codeError,
            'message' => 'Page non trouvée, vérifiée votre saisie'
        ]);

        $event->setResponse((new Response())->setContent($contentPage));
    }
}
