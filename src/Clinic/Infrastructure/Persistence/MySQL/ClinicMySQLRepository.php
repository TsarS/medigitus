<?php
declare(strict_types=1);

namespace Clinic\Infrastructure\Persistence\MySQL;


use Clinic\Domain\Entity\Clinic;
use Clinic\Domain\Repository\ClinicRepository;
use Exception;
use PDO;

final class ClinicMySQLRepository implements ClinicRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function add($clinic): void
    {
        $stmt = $this->connection;
        $stmt->beginTransaction();
        $clinic_table = $stmt->prepare("INSERT INTO `clinic` (`id`, `inn`, `name`,`legalForm`,`country`, `post_code`, `region`, `city`, `street`,`building`, `lat`,`lon`,`date`) VALUES (:id, :inn, :name, :legalForm,:country, :post_code, :region, :city, :street, :building,:lat, :lon, :date)");
        $directions_table = $stmt->prepare("INSERT INTO `clinic_directions` (`clinic_id`,`name`,`date`) VALUES (:clinic_id, :direction_name,  :date)");

        try {
            $clinic_table->execute([
                ':id' => $clinic->getId()->getId(),
                ':inn' => $clinic->getLegal()->getInn(),
                ':name' => $clinic->getName()->getName(),
                ':legalForm' => $clinic->getCorporateForm(),
                ':country' => $clinic->getAddress()->getCountry(),
                ':post_code' => $clinic->getAddress()->getPostCode(),
                ':region' => $clinic->getAddress()->getRegion(),
                ':city' => $clinic->getAddress()->getCity(),
                ':street' => $clinic->getAddress()->getStreet(),
                ':building' => $clinic->getAddress()->getHouse(),
                ':lat' => $clinic->getAddress()->getLat(),
                ':lon' => $clinic->getAddress()->getLon(),
                ':date' => $clinic->getDate()->format('Y-m-d H:i:s')
            ]);
            foreach ($clinic->getDirections() as $direction) {
                $directions_table->execute([
                    ':clinic_id' => $clinic->getID()->getId(),
                    ':direction_name' => $direction,
                    ':date' => $clinic->getDate()->format('Y-m-d H:i:s')
                ]);
            }
            $stmt->commit();
        } catch (Exception $e) {
            $stmt->rollback();
            echo $e->getMessage();
        }

    }


    public function save(Clinic $clinic): void
    {
        $stmt = $this->connection;
        $stmt->beginTransaction();
        $clinic_table = $stmt->prepare("UPDATE `clinic` SET  inn=:inn, name=:name, legalForm =:legalForm, country=:country, post_code=:post_code, region=:region, city=:city, street=:street,building=:building, lat=:lat, lon=:lon, date=:date WHERE id=:id");
        $directions_table = $stmt->prepare("UPDATE `clinic_directions` SET name=:direction_name, date=:date WHERE clinic_id= :clinic_id");

        try {
            $clinic_table->execute([
                ':id' => $clinic->getId()->getId(),
                ':inn' => $clinic->getLegal()->getInn(),
                ':name' => $clinic->getName()->getName(),
                ':legalForm' => $clinic->getCorporateForm(),
                ':country' => $clinic->getAddress()->getCountry(),
                ':post_code' => $clinic->getAddress()->getPostCode(),
                ':region' => $clinic->getAddress()->getRegion(),
                ':city' => $clinic->getAddress()->getCity(),
                ':street' => $clinic->getAddress()->getStreet(),
                ':building' => $clinic->getAddress()->getHouse(),
                ':lat' => $clinic->getAddress()->getLat(),
                ':lon' => $clinic->getAddress()->getLon(),
                ':date' => $clinic->getDate()->format('Y-m-d H:i:s')
            ]);
            foreach ($clinic->getDirections() as $direction) {
                $directions_table->execute([
                    ':clinic_id' => $clinic->getID()->getId(),
                    ':direction_name' => $direction,
                    ':date' => $clinic->getDate()->format('Y-m-d H:i:s')
                ]);
            }
            $stmt->commit();
        } catch (Exception $e) {
            echo $e->getMessage();
            $stmt->rollback();

        }
    }

}