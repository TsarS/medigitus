<?php
declare(strict_types=1);

namespace Clinic\Application\Event\Create;


use Clinic\Application\Event\EventDispatcher;

final class ClinicEventDispatcher implements EventDispatcher
{

    public function dispatch(array $events): void
    {
        foreach ($events as $event) {
            file_put_contents("file.txt",get_class($event), FILE_APPEND);
        }
    }
}