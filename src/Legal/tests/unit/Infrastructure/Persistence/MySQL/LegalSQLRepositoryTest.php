<?php
declare(strict_types=1);

namespace Legal\tests\unit\Infrastructure\Persistence\MySQL;


use Legal\Infrastructure\Persistence\Hydrator;
use Legal\Infrastructure\Persistence\MySQL\LegalMySQLRepository;
use Legal\Infrastructure\Persistence\MySQL\LegalReadMySQLRepository;
use Legal\tests\unit\Infrastructure\Persistence\BaseLegalRepository;
use PDO;
use PDOException;

final class LegalSQLRepositoryTest extends BaseLegalRepository
{
    protected function setUp(): void
    {
        try {
            $connection = new PDO('mysql:host=localhost;dbname=rating_test', 'root', 'root');
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
       $truncate = $connection->prepare("DELETE FROM legal");
       $truncate->execute();
        $hydrator = new Hydrator();
        $this->repository = new LegalMySQLRepository($connection);
        $this->readRepository = new LegalReadMySQLRepository($connection, $hydrator);

    }
}