<?php
declare(strict_types=1);

namespace Clinic\tests\unit\Infrastructure\Persistence\MySQL;


use Clinic\Infrastructure\Persistence\Hydrator;
use Clinic\Infrastructure\Persistence\MySQL\ClinicMySQLRepository;
use Clinic\Infrastructure\Persistence\MySQL\ClinicReadMySQLRepository;
use Clinic\tests\unit\Infrastructure\Persistence\BaseClinicRepository;

use PDO;
use PDOException;

final class ClinicSQLRepositoryTest extends BaseClinicRepository
{
    protected function setUp(): void
    {
        try {
            $connection = new PDO('mysql:host=localhost;dbname=rating_test', 'root', 'root',
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_STRINGIFY_FETCHES => false,
                    PDO::ATTR_EMULATE_PREPARES => false]);

        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        $connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $connection->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, false);
       $truncate = $connection->prepare("DELETE FROM clinic");
         $truncate->execute();

        $hydrator = new Hydrator();
        $this->repository = new ClinicMySQLRepository($connection);
        $this->readRepository = new ClinicReadMySQLRepository($connection, $hydrator);

    }
}