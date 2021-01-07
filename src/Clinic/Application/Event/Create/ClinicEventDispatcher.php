<?php
declare(strict_types=1);

namespace Clinic\Application\Event\Create;


use Clinic\Application\Event\EventDispatcher;

final class ClinicEventDispatcher implements EventDispatcher
{

    public function dispatch(array $events): void
    {
        foreach ($events as $event) {
           var_dump($event);
        }
    }
}