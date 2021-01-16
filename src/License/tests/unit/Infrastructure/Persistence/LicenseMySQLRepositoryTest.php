<?php
declare(strict_types=1);

namespace License\tests\unit\Infrastructure\Persistence;


use License\Infrastructure\Persistence\MySQL\Connection;
use License\Infrastructure\Persistence\MySQL\Hydrator;
use License\Infrastructure\Persistence\MySQL\LicenseMySQLRepository;
use License\Infrastructure\Persistence\MySQL\LicenseReadMySQLRepository;

final class LicenseMySQLRepositoryTest extends BaseLicenseRepository
{
    protected function setUp(): void
    {
        $dbh = new Connection();
        $connection = $dbh->getConnection();
        $truncate = $connection->prepare("DELETE FROM license_address");
        $truncate->execute();
        $hydrator = new Hydrator();
        $this->repository = new LicenseMySQLRepository($connection);
        $this->readRepository = new LicenseReadMySQLRepository($connection, $hydrator);
    }
}