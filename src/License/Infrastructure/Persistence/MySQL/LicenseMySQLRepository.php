<?php
declare(strict_types=1);

namespace License\Infrastructure\Persistence\MySQL;


use License\Domain\Entity\License;
use License\Domain\Repository\LicenseRepository;
use PDO;
use PDOException;

final class LicenseMySQLRepository implements LicenseRepository
{
    /**
     * @var PDO
     */
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function add(License $license)
    {
        $this->connection->beginTransaction();
        try {
            $legal_table = $this->connection->prepare("INSERT INTO `license_address` (`id`, `inn`,`name`, `address`,`country`,`region`,`city`,`street`,`house`,`lat`,`lon`,`address_status`,`created_date`) VALUES (:id, :inn,:name, :address,:country,:region,:city,:street,:city,:lat,:lon,:address_status, :created_date)");
            $legal_works_table = $this->connection->prepare("INSERT INTO `license_works` (`address_id`, `work`, `number`, `date`,`activity_type`) VALUES (:address_id, :work, :number,:date, :activity_type)");
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
            $this->connection->commit();
        } catch (PDOException $e) {
            $this->connection->rollback();
            throw $e;
        }
    }


    public function save(License $license)
    {
        $this->connection->beginTransaction();
        try {
            $legal_table = $this->connection->prepare("UPDATE `license_address` SET inn=:inn, name=:name, address=:address, country=:country,region=:region,city=:city,street=:street,house=:house,lat=:lat,lon=:lon,address_status=:address_status,created_date=:created_date WHERE id=:id");
            $legal_works_table = $this->connection->prepare("UPDATE `license_works` SET  work=:work, number=:number, date=:date,activity_type=:activity_type  WHERE address_id=:address_id");
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
            $this->connection->commit();
        } catch (PDOException $e) {
            $this->connection->rollback();
            throw $e;
        }
    }

    public function updateWorks(License $license)
    {
        $this->connection->beginTransaction();
        try {
            $delete = $this->connection->prepare("DELETE FROM `license_works` WHERE address_id = :address_id_to_delete");
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
            $this->connection->commit();
        } catch (PDOException $e) {
            $this->connection->rollback();
            throw $e;
        }
    }



    private function getExtractLegalData(License $license): array
    {
        return [
            ':id' => $license->getId()->getId(),
            ':inn' => $license->getInn(),
            ':name' => $license->getName(),
            ':address' => $license->getPostAddress(),
            ':country' => $license->getAddress()->getCountry(),
            ':region' => $license->getAddress()->getRegion(),
            ':city' => $license->getAddress()->getCity(),
            ':street' => $license->getAddress()->getStreet(),
            ':house' => $license->getAddress()->getHouse(),
            ':lat' => $license->getAddress()->getLat(),
            ':lon' => $license->getAddress()->getLon(),
            ':address_status' => $license->getStatus(),
            ':created_date' => $license->getCreatedDate()->format('Y-m-d H:i:s')
        ];
    }
}