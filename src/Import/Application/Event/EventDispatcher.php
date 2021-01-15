<?php
declare(strict_types=1);

namespace Import\Application\Event;


interface EventDispatcher
{
    public function dispatch(array $events): void;
}