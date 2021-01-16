<?php
declare(strict_types=1);

namespace License\Infrastructure\Persistence\MySQL;


use DateTimeImmutable;
use License\Domain\Entity\License;
use License\Domain\Repository\LicenseReadRepository;
use License\Domain\VO\Address;
use License\Domain\VO\Id;
use License\Domain\VO\Work;
use License\Domain\VO\Works;
use License\Infrastructure\Persistence\Exception\NotFoundLicenseException;
use License\Infrastructure\Persistence\Exception\NotFoundLicenseWorksException;
use PDO;
use PDOException;

final class LicenseReadMySQLRepository implements LicenseReadRepository
{
    /**
     * @var PDO
     */
    private PDO $connection;
    /**
     * @var Hydrator
     */
    private Hydrator $hydrator;

    public function __construct(PDO $connection, Hydrator $hydrator)
    {
        $this->connection = $connection;
        $this->hydrator = $hydrator;
    }


    public function get(Id $id): License
    {

        $statement = $this->connection->prepare('SELECT id, inn, name, address, country, region, city, street, house, lat, lon, address_status, created_date FROM license_address WHERE id = ?');
        $statement_works = $this->connection->prepare('SELECT work,number,date,activity_type FROM license_works WHERE address_id = ?');
        $statement->bindValue(1, $id->getId());
        $statement_works->bindValue(1, $id->getId());
        $statement->execute();
        $statement_works->execute();
        $clinic = $statement->fetch();
        $clinic_works = $statement_works->fetchAll(PDO::FETCH_ASSOC);
        if (!$clinic) {
            throw new NotFoundLicenseException($id);
        }
        if (!$clinic_works) {
            throw new NotFoundLicenseWorksException($id);
        }
        try {
            return $this->hydrator->hydrate(License::class, [
                'id' => new Id($clinic['id']),
                'inn' => $clinic['inn'],
                'name' => $clinic['name'],
                'post_address' => $clinic['address'],
                'address' => new Address(
                    $clinic['country'],
                    $clinic['region'],
                    $clinic['city'],
                    $clinic['street'],
                    $clinic['house'],
                    $clinic['lat'],
                    $clinic['lon']
                ),
                'works' => new Works(array_map(function ($work) {
                    return new Work(
                        $work['work'],
                        $work['number'],
                        $work['date'],
                        $work['activity_type']
                    );
                }, $clinic_works)),
                'created_date' => new DateTimeImmutable($clinic['created_date']),
                'status' => $clinic["address_status"]
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }


    public function addressExist(string $address): bool
    {
        $statement = $this->connection->prepare("SELECT address FROM license_address WHERE (address=:address)");
        $statement->execute(
            [':address' => $address]
        );
        if ($statement->rowCount() > 0) {
            return true;
        } else return false;
    }

    public function getByAddress(string $address): License
    {
        $statement = $this->connection->prepare('SELECT id, inn, address FROM license_address WHERE address = ?');
        $statement->bindValue(1, $address);
        $statement->execute();
        $result = $statement->fetch();
        return $this->get(new Id($result["id"]));
    }
}