<?php
declare(strict_types=1);

namespace Legal\tests\unit\Application\Command\Create;



use Legal\Application\Command\CreateLegal\CreateLegalCommand;
use Legal\Application\Command\CreateLegal\CreateLegalHandler;
use Legal\Domain\Repository\LegalReadRepository;
use Legal\Domain\Repository\LegalRepository;
use Legal\Infrastructure\Persistence\Hydrator;
use Legal\Infrastructure\Persistence\MySQL\LegalMySQLRepository;
use Legal\Infrastructure\Persistence\MySQL\LegalReadMySQLRepository;
use PDO;
use PDOException;
use PHPUnit\Framework\TestCase;

final class CreateLegalHandlerTest extends TestCase
{
    /**
     * @var LegalRepository
     */
    protected $repository;
    /**
     * @var LegalReadRepository
     */
    protected $readRepository;
    protected function setUp(): void
    {

        //  $truncate = $connection->prepare("DELETE FROM legal");
        //  $truncate->execute();



    }
    public function testCreateLegalHandler()  {
        $command = new CreateLegalCommand(
            $inn = '5027076207',
            $ogrn = '1117746919597',
            $name = 'Для теста Хендлера',
            $legalForm = 'Общество с ограниченной ответственностью',
            $country = 'Российская Федерация',
            $post_code = '111033',
            $region = 'г.Москва',
            $city = 'Москва',
            $street = 'Волочаевская',
            $building = '15к1'
        );
        try {
            $connection = new PDO('mysql:host=localhost;dbname=rating_test', 'root', 'root');
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        $hydrator = new Hydrator();
        $repository = new LegalMySQLRepository($connection);
        $readRepository = new LegalReadMySQLRepository($connection, $hydrator);
        $handler = new CreateLegalHandler($repository,$readRepository);
        $handler->__invoke($command);
        $this->assertTrue($readRepository->existsByInn($inn));
    }
}