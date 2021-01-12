<?php
declare(strict_types=1);

namespace Direction\Application\Event;


interface EventDispatcher
{
    public function dispatch(array $events): void;
}