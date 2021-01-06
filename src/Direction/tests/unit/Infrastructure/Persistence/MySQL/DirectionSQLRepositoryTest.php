<?php
declare(strict_types=1);

namespace Direction\tests\unit\Infrastructure\Persistence\MySQL;


use Direction\Infrastructure\Persistence\MySQL\DirectionMySQLRepository;
use Direction\Infrastructure\Persistence\MySQL\DirectionReadMySQLRepository;
use Direction\tests\unit\Infrastructure\Persistence\BaseDirectionRepository;
use Direction\Infrastructure\Persistence\Hydrator;
use PDO;
use PDOException;

final class DirectionSQLRepositoryTest extends BaseDirectionRepository
{
    protected function setUp(): void
    {
        try {
            $connection = new PDO('mysql:host=localhost;dbname=rating_test', 'root', 'root');
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        $truncate = $connection->prepare("DELETE FROM direction");
        $truncate->execute();
        $hydrator = new Hydrator();
        $this->repository = new DirectionMySQLRepository($connection);
        $this->readRepository = new DirectionReadMySQLRepository($connection, $hydrator);

    }
}