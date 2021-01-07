<?php
declare(strict_types=1);

namespace Clinic\Infrastructure\Persistence\MySQL;


use Clinic\Domain\Entity\Clinic;
use Clinic\Domain\Repository\ClinicReadRepository;
use Clinic\Domain\VO\Address;
use Clinic\Domain\VO\Id;
use Clinic\Domain\VO\Legal;
use Clinic\Domain\VO\Name;
use Clinic\Infrastructure\Persistence\Exception\NotFoundClinicException;
use Clinic\Infrastructure\Persistence\Hydrator;
use DateTimeImmutable;
use PDO;

final class ClinicReadMySQLRepository implements ClinicReadRepository
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

    public function get(Id $id): Clinic
    {
        $statement = $this->connection->prepare('SELECT id, inn, name, legalForm, country, post_code, region,city,street,building, lat, lon, date FROM clinic WHERE id = ?');
        $statement_directions = $this->connection->prepare('SELECT name FROM clinic_directions WHERE clinic_id = ?');
        $statement->bindValue(1, $id->getId());
        $statement_directions->bindValue(1, $id->getId());
        $statement->execute();
        $statement_directions->execute();

        $clinic = $statement->fetch();
        $clinic_directions = $statement_directions->fetchAll(PDO::FETCH_COLUMN);
        if (!$clinic) {
            throw new NotFoundClinicException($id->getId());
        }
        if (!$clinic_directions) {
            throw new NotFoundClinicException($id->getId());
        }

        return $this->hydrator->hydrate(Clinic::class, [
            'id' => new Id($clinic['id']),
            'legal' => new Legal(
                $clinic['inn'],
                $clinic['legalForm'],
            ),
            'name' => new Name($clinic['name']),
            'address' => new Address(
                $clinic['country'],
                $clinic['post_code'],
                $clinic['region'],
                $clinic['city'],
                $clinic['street'],
                $clinic['building'],
                $clinic['lat'],
                $clinic['lon']
            ),
            'directions' => array_map($clinic_directions['name'],$clinic_directions),
            'date' => new DateTimeImmutable($clinic['date']),
        ]);

    }

    public function ifExistByInnAndAddress($inn, $post_code, $city, $street,$building): bool
    {
        $statement = $this->connection->prepare('SELECT inn,post_code,city,street,building FROM clinic WHERE inn = :inn AND post_code=:post_code AND  city=:city AND street=:street AND building=:building');
        $statement->execute([
                ':inn' => $inn,
                ':post_code' =>$post_code,
                ':city' => $city,
                ':street' => $street,
                ':building' => $building

            ]);
        if($statement->rowCount() > 0){
            return true;
        } else return false;
    }
}