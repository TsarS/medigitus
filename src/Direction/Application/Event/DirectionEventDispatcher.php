<?php
declare(strict_types=1);

namespace Direction\Application\Event;


final class DirectionEventDispatcher implements EventDispatcher
{
    public function dispatch(array $events): void
    {
        foreach ($events as $event) {

            file_put_contents("file.txt",get_class($event), FILE_APPEND);

// открываем файл, если файл не существует,
//делается попытка создать его
            //$fp = fopen("file.txt", "w");

// записываем в файл текст
            // fwrite($fp, get_class($event));

// закрываем
            //fclose($fp);

            var_dump($event);
        }
    }
}