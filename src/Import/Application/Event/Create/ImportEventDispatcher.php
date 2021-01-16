<?php
declare(strict_types=1);

namespace Import\Application\Event\Create;


use Import\Application\Command\ChangeAddress\ChangeAddressCommand;
use Import\Application\Command\ChangeAddress\ChangeAddressHandler;
use Import\Application\Event\EventDispatcher;
use Import\Infrastructure\Persistence\MySQL\Hydrator;
use Import\Infrastructure\Persistence\MySQL\LicenseMySQLRepository;
use Import\Infrastructure\Persistence\MySQL\LicenseReadMySQLRepository;
use PDO;
use PDOException;

final class ImportEventDispatcher implements EventDispatcher
{
    public function __construct()
    {
    }

    public function dispatch(array $events): void
    {
        try {
            $connection = new PDO('mysql:host=localhost;dbname=rating_test', 'root', 'root');
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        $hydrator = new Hydrator();
        $repository = new LicenseMySQLRepository($connection);
        $readRepository = new LicenseReadMySQLRepository($connection, $hydrator);

        foreach ($events as $event) {
   $handler = new ChangeAddressHandler($repository, $readRepository, new ImportEventDispatcher());
   $handler->__invoke(new ChangeAddressCommand($event->getId()->getId()));

        }
    }
}