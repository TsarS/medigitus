<?php
declare(strict_types=1);

namespace Import\Infrastructure\Persistence\MySQL;


use DateTimeImmutable;
use Import\Domain\Entity\License;
use Import\Domain\Repository\LicenseReadRepository;
use Import\Domain\VO\Id;
use Import\Domain\VO\Work;
use Import\Domain\VO\Works;
use Import\Infrastructure\Persistence\Exception\NotFoundLicenseException;
use Import\Infrastructure\Persistence\Exception\NotFoundLicenseWorksException;
use PDO;

final class LicenseReadMySQLRepository implements LicenseReadRepository
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
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function get(Id $id): License
    {
        $statement = $this->connection->prepare('SELECT id, inn, address,created_date FROM license_address WHERE id = ?');
        $statement_works = $this->connection->prepare('SELECT work,number,date,activity_type FROM license_works WHERE address_id = ?');
        $statement->bindValue(1, $id->getId());
        $statement_works->bindValue(1, $id->getId());
        $statement->execute();
        $statement_works->execute();

        $clinic = $statement->fetch();
        $clinic_works = $statement_works->fetchAll(PDO::FETCH_ASSOC);
        if (!$clinic) {
            throw new NotFoundLicenseException($id->getId());
        }
        if (!$clinic_works) {
            throw new NotFoundLicenseWorksException($id->getId());
        }
        return $this->hydrator->hydrate(License::class, [
            'id' => new Id($clinic['id']),
            'inn' => $clinic['inn'],
            'post_address' => $clinic['address'],
            'works' => new Works(array_map(function ($work) {
                return new Work(
                    $work['work'],
                    $work['number'],
                    $work['date'],
                    $work['activity_type']
                );
            },$clinic_works)),
            'created_date' => new DateTimeImmutable($clinic['created_date']),
        ]);


    }

    public function getByAddress(string $address)
    {
        $statement = $this->connection->prepare('SELECT id, inn, address FROM license_address WHERE address = ?');
        $statement->bindValue(1, $address);
        $statement->execute();
        $result = $statement->fetch();
        return $this->get(new Id($result["id"]));
    }

    public function addressExist(string $address)
    {
        $statement = $this->connection->prepare("SELECT address FROM license_address WHERE (address=:address)");
        $statement->execute(
            [':address' => $address]
        );
        if ($statement->rowCount() > 0) {
            return true;
        } else return false;
    }
}