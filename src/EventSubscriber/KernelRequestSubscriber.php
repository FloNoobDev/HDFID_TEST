<?php

namespace App\EventSubscriber;

use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Helper\ProgressIndicator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class KernelRequestSubscriber implements EventSubscriberInterface
{
    public function onKernelRequest(RequestEvent $event): void
    { 
        // dd($event->getResponse());
        // // $event->getKernel()
        // if($event->getKernel()){

        //     $response = $event->getResponse();
        //     $jsonRaw = json_decode($response->getContent(),true);
        //     // $response->setContent($jsonRaw);
        //     dd($response);
        // }

    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }
}
