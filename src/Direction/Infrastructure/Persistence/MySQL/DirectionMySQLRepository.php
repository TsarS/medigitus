<?php
declare(strict_types=1);

namespace Direction\Infrastructure\Persistence\MySQL;


use Direction\Domain\Entity\Direction;
use Direction\Domain\Repository\DirectionRepository;
use Direction\Domain\VO\Id;
use Exception;
use PDO;

final class DirectionMySQLRepository implements DirectionRepository
{
    private PDO $connection;
    private PDO $statement;
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
        $this->statement = $this->connection;
        $this->statement->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function add(Direction $direction): void
    {

        try {
            $this->statement->beginTransaction();
            $direction_table = $this->statement->prepare("INSERT INTO `direction` (`id`,`name`, `date`) VALUES (:id, :name, :date)");
            $direction_table->execute(self::getExtractedData($direction));

            $this->statement->commit();
        } catch (Exception $e) {
            $this->statement->rollback();
            echo $e->getMessage();
        }
    }


    public function save(Direction $direction): void {
        try {
            $this->statement->beginTransaction();
            $direction_table = $this->statement->prepare("UPDATE direction SET name=:name, date=:date WHERE id=:id");
            $direction_table->execute(self::getExtractedData($direction));
            $this->statement->commit();
        } catch (Exception $e) {
            $this->statement->rollback();
            echo $e->getMessage();
        }
    }





    private static function getExtractedData(Direction $direction) : array {
        return [
            ':id' => $direction->getId()->getId(),
            ':name' => $direction->getName(),
            ':date' => $direction->getDate()->format('Y-m-d H:i:s')
        ];
    }

    public function delete(string $id): void
    {
        try {
            $this->statement->beginTransaction();
            $direction_table = $this->statement->prepare("DELETE FROM direction WHERE id =:id");
            $direction_table->execute(
                [':id' => $id]
            );
            $this->statement->commit();
        } catch (Exception $e) {
            $this->statement->rollback();
            echo $e->getMessage();
        }
    }
}