<?php
declare(strict_types=1);

namespace Import\Infrastructure\Persistence\MySQL;


use Exception;
use Import\Domain\Entity\License;
use Import\Domain\Repository\LicenseRepository;
use Import\Domain\VO\Id;
use PDO;

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

        try {
            $this->statement->beginTransaction();
            $legal_table = $this->statement->prepare("INSERT INTO `license_address` (`id`, `inn`, `address`,`created_date`) VALUES (:id, :inn, :address, :created_at)");
            $legal_works_table = $this->statement->prepare("INSERT INTO `license_works` (`address_id`, `work`, `number`, `date`,`activity_type`) VALUES (:address_id, :work, :number,:date, :activity_type)");

            $legal_table->execute(self::getExtractLegalData($license));
            foreach ($license->getWorks() as $work) {
                $legal_works_table->execute(self::getExtractWorksData($license->getId()->getId(),$work));
            }
            $this->statement->commit();
        } catch (Exception $e) {
            $this->statement->rollback();
            echo $e->getMessage();
        }
    }


    public function save(License $license)
    {

        try {
            $this->statement->beginTransaction();
            $legal_table = $this->statement->prepare("UPDATE `license_address` SET inn=:inn, address=:address WHERE id=:id");
            $legal_works_table = $this->statement->prepare("UPDATE `license_works` SET  work=:work, number=:number,activity_type=:activity_type, date=:date  WHERE address_id=:address_id");

            $legal_table->execute(self::getExtractLegalData($license));
            foreach ($license->getWorks() as $work) {
                $legal_works_table->execute(self::getExtractWorksData($license->getId()->getId(),$work));
            }
            $this->statement->commit();
        } catch (Exception $e) {
            $this->statement->rollback();
            echo $e->getMessage();
        }
    }
    public function addressExist(string $address) {

    }

    private function getExtractLegalData(License $license) {
        return [
            ':id' => $license->getId()->getId(),
            ':inn' => $license->getInn(),
            ':address' => $license->getPostAddress(),
            ':created_at' => $license->getCreatedDate()->format('Y-m-d H:i:s')
        ];
    }
    private function getExtractWorksData(string $id, array $work) {
        return [
            'address_id' => $id,
            'work' => $work["work"],
            'number' => $work["number"],
            'date' => $work["date"],
            'activity_type' => $work["activity_type"]

        ];
    }
}