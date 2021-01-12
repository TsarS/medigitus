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
        $legal_table = $stmt->prepare("INSERT INTO `legal` (`id`, `inn`, `ogrn`,`name`,`legalForm`,`address`, `date`) VALUES (:id, :inn, :ogrn, :name, :legalForm,:address, :date)");

        $stmt->beginTransaction();
        try {
            $legal_table->execute(self::getExtractedData($legal));

            $stmt->commit();
        } catch (Exception $e) {
            $stmt->rollback();
            echo $e->getMessage();
        }
    }


    public function save(Legal $legal): void
    {
        $stmt = $this->connection;
        $legal_table = $stmt->prepare("UPDATE `legal` SET  inn=:inn, ogrn=:ogrn, name=:name, legalForm =:legalForm, address=:address, date=:date WHERE id=:id");
        try {
            $legal_table->execute(self::getExtractedData($legal));

            $stmt->commit();
        } catch (Exception $e) {
            $stmt->rollback();
            echo $e->getMessage();
        }
    }
   private static function getExtractedData(Legal $legal) : array {
        return [
            ':id' => $legal->getId()->getId(),
            ':inn' => $legal->getInn()->getInn(),
            ':ogrn' => $legal->getOgrn()->getOgrn(),
            ':name' => $legal->getName()->getName(),
            ':legalForm' => $legal->getLegalForm()->getLegalForm(),
            ':address' => $legal->getAddress(),
            ':date' => $legal->getDate()->format('Y-m-d H:i:s')
        ];
   }
}