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
    private PDO $statement;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
        $this->statement = $this->connection;
        $this->statement->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function add($clinic): void
    {

        try {
            $this->statement->beginTransaction();
            $clinic_table = $this->statement->prepare("INSERT INTO `clinic` (`id`, `inn`, `name`,`legalForm`,`country`, `post_code`, `region`, `city`, `street`,`building`, `lat`,`lon`,`date`) VALUES (:id, :inn, :name, :legalForm,:country, :post_code, :region, :city, :street, :building,:lat, :lon, :date)");
            $directions_table = $this->statement->prepare("INSERT INTO `clinic_directions` (`clinic_id`,`name`,`ambulance`,`surgery`,`date`) VALUES (:clinic_id, :direction_name, :ambulance,:surgery,  :date)");
            $clinic_table->execute(self::getExtractedData($clinic));

            foreach ($clinic->getDirections() as $direction) {
                $directions_table->execute([
                    ':clinic_id' => $clinic->getID()->getId(),
                    ':direction_name' => $direction->getName(),
                    ':ambulance' => $direction->isAmbulance(),
                    ':surgery' => $direction->isSurgery(),
                    ':date' => $clinic->getDate()->format('Y-m-d H:i:s')
                ]);
            }
            $this->statement->commit();
        } catch (Exception $e) {
            $this->statement->rollback();
        }

    }

    public function save(Clinic $clinic): void
    {
        try {
            $this->statement->beginTransaction();
            $clinic_table = $this->statement->prepare("UPDATE `clinic` SET  inn=:inn, name=:name, legalForm =:legalForm, country=:country, post_code=:post_code, region=:region, city=:city, street=:street,building=:building, lat=:lat, lon=:lon, date=:date WHERE id=:id");
            $directions_table = $this->statement->prepare("UPDATE `clinic_directions` SET name=:direction_name, ambulance=:ambulance, surgery=:surgery,date=:date WHERE clinic_id= :clinic_id");

            $clinic_table->execute(self::getExtractedData($clinic));

            foreach ($clinic->getDirections() as $direction) {
                $directions_table->execute([
                    ':clinic_id' => $clinic->getID()->getId(),
                    ':direction_name' => $direction->getName(),
                    ':ambulance' => $direction->isAmbulance(),
                    ':surgery' => $direction->isSurgery(),
                    ':date' => $clinic->getDate()->format('Y-m-d H:i:s')
                ]);
            }
            $this->statement->commit();
        } catch (Exception $e) {
            echo $e->getMessage();
            $this->statement->rollback();

        }
    }

    private static function getDirectionsData(Clinic $clinic): array
    {

    }


    private static function getExtractedData(Clinic $clinic): array
    {
        return [
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
        ];
    }
}