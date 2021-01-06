<?php
declare(strict_types=1);

namespace Direction\Infrastructure\Persistence\MySQL;


use Direction\Domain\Entity\Direction;
use Direction\Domain\Repository\DirectionRepository;
use Exception;
use PDO;

final class DirectionMySQLRepository implements DirectionRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function add(Direction $direction): void
    {
        $stmt = $this->connection;
        $direction_table = $stmt->prepare("INSERT INTO `direction` (`id`,`name`, `date`) VALUES (:id, :name, :date)");

        $stmt->beginTransaction();
        try {
            $direction_table->execute([
                ':id' => $direction->getId()->getId(),
                ':name' => $direction->getName(),
                ':date' => $direction->getDate()->format('Y-m-d H:i:s')
            ]);

            $stmt->commit();
        } catch (Exception $e) {
            $stmt->rollback();
            echo $e->getMessage();
        }
    }


    public function save(Direction $direction): void
    {
        $stmt = $this->connection;
        $direction_table = $stmt->prepare("UPDATE direction SET name=:name, date=:date WHERE id=:id");
        try {
            $direction_table->execute([
                ':id' => $direction->getId()->getId(),
                ':name' => $direction->getName(),
                ':date' => $direction->getDate()->format('Y-m-d H:i:s')
            ]);

            $stmt->commit();
        } catch (Exception $e) {
            $stmt->rollback();
            echo $e->getMessage();
        }
    }

}