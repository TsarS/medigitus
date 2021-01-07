<?php
declare(strict_types=1);

namespace Clinic\Application\Event;


interface EventDispatcher
{
    public function dispatch(array $events): void;
}