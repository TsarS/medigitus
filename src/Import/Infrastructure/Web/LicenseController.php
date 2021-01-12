<?php
declare(strict_types=1);

namespace Import\Infrastructure\Web;


use Legal\Application\Command\CreateLegal\CreateLegalCommand;
use Legal\Application\Command\CreateLegal\CreateLegalHandler;
use Legal\Infrastructure\Persistence\Hydrator;
use Legal\Infrastructure\Persistence\MySQL\LegalMySQLRepository;
use Legal\Infrastructure\Persistence\MySQL\LegalReadMySQLRepository;
use PDO;

final class LicenseController
{
    private PDO $statement;
    private PDO $connection;

    public function __construct($connection) {
      
        $this->connection = $connection;
        $this->statement = $this->connection;
        $this->statement->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function showClinicWithLicence() {
        $sql_table = $this->statement->prepare(" ");
        $sql_table->execute();
        $clinics = $sql_table->fetchAll();
    }




    public function createLegal() {

        $sql_table = $this->statement->prepare("SELECT id, inn, ogrn, full_name_licensee, form, address from `licences` ");        $sql_table->execute();
        $legals = $sql_table->fetchAll();
        $hydrator = new Hydrator();
        $repository = new LegalMySQLRepository($this->connection);
        $readRepository = new LegalReadMySQLRepository($this->connection, $hydrator);
        foreach ($legals as $legal) {
            $command = new CreateLegalCommand(
                $legal['inn'],
                $legal['ogrn'],
                $legal['full_name_licensee'],
                $legal['form'],
                $legal['address']
            );
            $handler = new CreateLegalHandler($repository,$readRepository);
            $handler->__invoke($command);

        }

    }



    public function showClinics()
    {








    }
}