<?php
declare(strict_types=1);

namespace Direction\Infrastructure\Persistence\MySQL;


use DateTimeImmutable;
use Direction\Domain\Entity\Direction;
use Direction\Domain\Repository\DirectionReadRepository;
use Direction\Domain\VO\Id;
use Direction\Infrastructure\Persistence\Exception\NotFoundDirectionException;
use Direction\Infrastructure\Persistence\Hydrator;
use PDO;

final class DirectionReadMySQLRepository implements DirectionReadRepository
{
    /**
     * @var
     */
    private $connection;
    /**
     * @var Hydrator
     */
    private Hydrator $hydrator;
    public function __construct(PDO $connection, Hydrator $hydrator)
    {

        $this->connection = $connection;
        $this->hydrator = $hydrator;
    }

    public function get(Id $id): Direction
    {

        $statement = $this->connection->prepare('SELECT id, name, date FROM direction WHERE id = ?');
        $statement->bindValue(1, $id->getId());
        $statement->execute();

        $direction = $statement->fetch();

        if (!$direction) {
            throw new NotFoundDirectionException($id->getId());
        }
        return $this->hydrator->hydrate(Direction::class, [
            'id' => new Id($direction['id']),
            'name' => $direction['name'],
            'date' => new DateTimeImmutable($direction['date']),
        ]);
    }

}