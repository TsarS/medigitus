<?php
declare(strict_types=1);

namespace Legal\Infrastructure\Persistence\MySQL;


use Exception;
use Legal\Domain\Entity\Legal;
use Legal\Domain\Repository\LegalRepository;
use PDO;

final class LegalMySQLRepository implements LegalRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function add($legal): void
    {
        $stmt = $this->connection;
        $legal_table = $stmt->prepare("INSERT INTO `legal` (`id`, `inn`, `ogrn`,`name`,`legalForm`,`country`, `post_code`, `region`, `city`, `street`,`building`, `date`) VALUES (:id, :inn, :ogrn, :name, :legalForm,:country, :post_code, :region, :city, :street, :building, :date)");

        $stmt->beginTransaction();
        try {
            $legal_table->execute([
                ':id' => $legal->getId()->getId(),
                ':inn' => $legal->getInn()->getInn(),
                ':ogrn' => $legal->getOgrn()->getOgrn(),
                ':name' => $legal->getName()->getName(),
                ':legalForm' => $legal->getLegalForm()->getLegalForm(),
                ':country' => $legal->getAddress()->getCountry(),
                ':post_code' => $legal->getAddress()->getPostCode(),
                ':region' => $legal->getAddress()->getRegion(),
                ':city' => $legal->getAddress()->getCity(),
                ':street' => $legal->getAddress()->getStreet(),
                ':building' => $legal->getAddress()->getBuilding(),
                ':date' => $legal->getDate()->format('Y-m-d H:i:s')
            ]);

            $stmt->commit();
        } catch (Exception $e) {
            $stmt->rollback();
            echo $e->getMessage();
        }
    }


    public function save(Legal $legal): void
    {
        $stmt = $this->connection;
        $legal_table = $stmt->prepare("UPDATE `legal` SET id=:id, inn=:inn, ogrn=:ogrn, name=:name, legalForm =:legalForm, country=:country, post_code=:post_code, region=:region, city=:city, street=:street,building=:building, date=:date) VALUES (:id, :inn, :ogrn, :name, :legalForm,:country, :post_code, :region, :city, :street, :building, :date)");
        try {
            $legal_table->execute([
                ':id' => $legal->getId()->getId(),
                ':inn' => $legal->getInn()->getInn(),
                ':ogrn' => $legal->getOgrn()->getOgrn(),
                ':name' => $legal->getName()->getName(),
                ':legalForm' => $legal->getLegalForm()->getLegalForm(),
                ':country' => $legal->getAddress()->getCountry(),
                ':post_code' => $legal->getAddress()->getPostCode(),
                ':region' => $legal->getAddress()->getRegion(),
                ':city' => $legal->getAddress()->getCity(),
                ':street' => $legal->getAddress()->getStreet(),
                ':building' => $legal->getAddress()->getBuilding(),
                ':date' => $legal->getDate()->format('Y-m-d H:i:s')
            ]);

            $stmt->commit();
        } catch (Exception $e) {
            $stmt->rollback();
            echo $e->getMessage();
        }
    }

}