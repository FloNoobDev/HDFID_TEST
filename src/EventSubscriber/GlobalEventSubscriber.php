<?php

namespace App\EventSubscriber;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\FinishRequestEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\Event\ViewEvent;

class GlobalEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private LoggerInterface $loggerInterface
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onRequestEvent'],
            KernelEvents::CONTROLLER => ['onControllerEvent'],
            KernelEvents::CONTROLLER_ARGUMENTS => ['onControllerArgumentsEvent'],
            KernelEvents::FINISH_REQUEST => ['onFinishRequestEvent'],
            KernelEvents::RESPONSE => ['onResponseEvent'],
            KernelEvents::VIEW => ['onViewEvent'],
        ];
    }

    public function onRequestEvent(RequestEvent $evt): void
    {
        $this->loggerInterface->log('INFO',$evt->getRequest());
    }
    public function onControllerEvent(ControllerEvent $evt): void
    {
    }
    public function onControllerArgumentsEvent(ControllerArgumentsEvent $evt): void
    {
    }
    public function onResponseEvent(ResponseEvent $evt): void
    {
    }
    public function onFinishRequestEvent(FinishRequestEvent $evt): void
    {
    }
    public function onViewEvent(ViewEvent $evt)
    {
    }
}
