<?php
declare(strict_types=1);

namespace Import\Infrastructure\Persistence\MySQL;


use Import\Domain\Entity\License;
use Import\Domain\Repository\LicenseRepository;
use PDO;
use PDOException;

final class LicenseMySQLRepository implements LicenseRepository
{
    private PDO $connection;
    private PDO $statement;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
        $this->statement = $this->connection;
        $this->statement->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function add(License $license)
    {
        $this->statement->beginTransaction();
        try {
            $legal_table = $this->statement->prepare("INSERT INTO `license_address` (`id`, `inn`, `address`,`created_date`) VALUES (:id, :inn, :address, :created_date)");
            $legal_works_table = $this->statement->prepare("INSERT INTO `license_works` (`address_id`, `work`, `number`, `date`,`activity_type`) VALUES (:address_id, :work, :number,:date, :activity_type)");
            $legal_table->execute(self::getExtractLegalData($license));
            foreach ($license->getWorks() as $work) {
                $legal_works_table->execute([
                    'address_id' => $license->getId()->getId(),
                    'work' => $work->getWork(),
                    'number' => $work->getNumber(),
                    'date' => $work->getDate(),
                    'activity_type' => $work->getActivityType()
                ]);
            }
            $this->statement->commit();
        } catch (PDOException $e) {
            $this->statement->rollback();
            throw $e;
        }
    }


    public function save(License $license)    {

        $this->statement->beginTransaction();
        try {
            $legal_table = $this->statement->prepare("UPDATE `license_address` SET inn=:inn, address=:address, created_date=:created_date WHERE id=:id");
            $legal_works_table = $this->statement->prepare("UPDATE `license_works` SET  work=:work, number=:number, date=:date,activity_type=:activity_type  WHERE address_id=:address_id");
            $legal_table->execute(self::getExtractLegalData($license));
            foreach ($license->getWorks() as $work) {
                $legal_works_table->execute([
                    'address_id' => $license->getId()->getId(),
                    'work' => $work->getWork(),
                    'number' => $work->getNumber(),
                    'date' => $work->getDate(),
                    'activity_type' => $work->getActivityType()
                ]);
            }
            $this->statement->commit();
        } catch (PDOException $e) {
            $this->statement->rollback();
            throw $e;
        }
    }

    public function updateWorks(License $license)
    {
        $this->statement->beginTransaction();
        try {
            $delete = $this->statement->prepare("DELETE FROM `license_works` WHERE address_id = :address_id_to_delete");
            $id_delete= $license->getId()->getId();
            $delete->bindParam(':address_id_to_delete',$id_delete);
            $delete->execute();
            $legal_works_table = $this->statement->prepare("INSERT INTO `license_works` (`address_id`, `work`, `number`, `date`,`activity_type`) VALUES (:address_id, :work, :number,:date, :activity_type)");
            foreach ($license->getWorks() as $work) {
                $legal_works_table->execute([
                    'address_id' => $license->getId()->getId(),
                    'work' => $work->getWork(),
                    'number' => $work->getNumber(),
                    'date' => $work->getDate(),
                    'activity_type' => $work->getActivityType()
                ]);
            }
            $this->statement->commit();
        } catch (PDOException $e) {
            $this->statement->rollback();
            throw $e;
        }
    }

    private function getExtractLegalData(License $license): array
    {
        return [
            ':id' => $license->getId()->getId(),
            ':inn' => $license->getInn(),
            ':address' => $license->getPostAddress(),
            ':created_date' => $license->getCreatedDate()->format('Y-m-d H:i:s')
        ];
    }
    /*
        private function getExtractWorksData(License $license): array
        {
            return [
                'address_id' => $license->getId()->getId(),
                'work' => $license->getWorks()->,
                'number' => $work->getNumber(),
                'date' => $work->getDate(),
                'activity_type' => $work->getActivityType()

            ];
        }
    */
}