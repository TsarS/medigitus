<?php
declare(strict_types=1);

namespace License\Application\Event;


interface EventDispatcher
{
    public function dispatch(array $events): void;
}