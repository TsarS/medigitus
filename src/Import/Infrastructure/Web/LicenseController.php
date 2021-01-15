<?php
declare(strict_types=1);

namespace Import\Infrastructure\Web;


use Exception;
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

    public function showClinicsWithLicence() {
        $sql_clinic = $this->statement->prepare("SELECT  il.inn, il.full_name_licensee,ipa.id, ipa.address FROM `import_legal` il JOIN `import_post_address` ipa WHERE ipa.inn = il.inn GROUP BY ipa.address");
        $sql_clinic->execute();
        return $sql_clinic->fetchAll();
    }
    public function getWorksByAddress($id) {
        try {
            $sql_works = $this->statement->prepare("SELECT  iw.work,iw.number,iw.date,iw.activity_type FROM `import_works` iw  WHERE iw.address_id = :address_id");
            $sql_works->execute([
                ':address_id' => $id
            ]);
            return $sql_works->fetchAll(PDO::FETCH_NUM);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

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