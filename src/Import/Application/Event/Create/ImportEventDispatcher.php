<?php
declare(strict_types=1);

namespace Import\Application\Event\Create;


use Import\Application\Event\EventDispatcher;

final class ImportEventDispatcher implements EventDispatcher
{

    public function dispatch(array $events): void
    {
        foreach ($events as $event) {
            file_put_contents("file.txt",get_class($event), FILE_APPEND);
        }
    }
}