<?php

namespace Intaro\PinbaBundle\EventListener;

use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class ScriptNameConfigureListener
{
    public function onRequest(RequestEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }

        if (!function_exists('pinba_script_name_set') || PHP_SAPI === 'cli') {
            return;
        }

        pinba_script_name_set($event->getRequest()->getRequestUri());
    }

    public function onConsoleCommand(ConsoleCommandEvent $event)
    {
        if (!function_exists('pinba_script_name_set') || PHP_SAPI !== 'cli') {
            return;
        }

        pinba_script_name_set($_SERVER['SCRIPT_NAME'].' '.$event->getCommand()->getName());
    }
}
