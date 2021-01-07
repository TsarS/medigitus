<?php
declare(strict_types=1);

namespace Legal\Infrastructure\Persistence\MySQL;


use DateTimeImmutable;
use Legal\Domain\Entity\Legal;
use Legal\Domain\Repository\LegalReadRepository;
use Legal\Domain\VO\Address;
use Legal\Domain\VO\Id;
use Legal\Domain\VO\Inn;
use Legal\Domain\VO\LegalForm;
use Legal\Domain\VO\Name;
use Legal\Domain\VO\Ogrn;
use Legal\Infrastructure\Persistence\Exception\NotFoundLegalException;
use Legal\Infrastructure\Persistence\Hydrator;
use PDO;

final class LegalReadMySQLRepository implements LegalReadRepository
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

    public function get(Id $id): Legal
    {

        $statement = $this->connection->prepare('SELECT id, inn, ogrn, name, legalForm, country, post_code, region,city,street,building, date FROM legal WHERE id = ?');
        $statement->bindValue(1, $id->getId());
        $statement->execute();

        $legal = $statement->fetch();

        if (!$legal) {
            throw new NotFoundLegalException($id->getId());
        }
        return $this->hydrator->hydrate(Legal::class, [
            'id' => new Id($legal['id']),
            'inn' => new Inn($legal['inn']),
            'ogrn' => new Ogrn($legal['ogrn']),
            'name' => new Name($legal['name']),
            'legalForm' => new LegalForm($legal['legalForm']),
            'address' => new Address(
                $legal['country'],
                $legal['post_code'],
                $legal['region'],
                $legal['city'],
                $legal['street'],
                $legal['building']
            ),
            'date' => new DateTimeImmutable($legal['date']),
        ]);
    }
    public function existsByInn($inn): bool
    {
        $statement = $this->connection->prepare("SELECT inn FROM legal WHERE (inn=:inn)");
        $statement->execute(
            [':inn' => $inn]
        );
      //  $check = $statement->fetchColumn();
        if($statement->rowCount() > 0){
           return true;
        } else return false;

      /*  if (isset($check) && !empty($check) && $check>0){
            return true;
        } else return false;
      */
    }

}