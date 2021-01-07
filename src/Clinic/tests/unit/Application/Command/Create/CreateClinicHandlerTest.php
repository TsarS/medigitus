<?php
declare(strict_types=1);

namespace Application\Command\Create;


use Clinic\Application\Command\Create\CreateClinicCommand;
use Clinic\Application\Command\Create\CreateClinicHandler;
use Clinic\Infrastructure\Persistence\Hydrator;
use Clinic\Infrastructure\Persistence\MySQL\ClinicMySQLRepository;
use Clinic\Infrastructure\Persistence\MySQL\ClinicReadMySQLRepository;
use PDO;
use PDOException;
use PHPUnit\Framework\TestCase;

final class CreateClinicHandlerTest extends TestCase
{
    public function testCreateClinicWithHandler()
    {
        try {
            $connection = new PDO('mysql:host=localhost;dbname=rating_test', 'root', 'root');
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        $hydrator = new Hydrator();
        $repository = new ClinicMySQLRepository($connection);
        $readRepository = new ClinicReadMySQLRepository($connection, $hydrator);
        $handler = new CreateClinicHandler($repository, $readRepository);
        $command = new CreateClinicCommand(
            '7729695811',
            'Частная',
            'Хедлер клиника',
            'Российская Федерация',
            '111033',
            'г.Москва',
            'Москва',
            'Волочаевская',
            '15к1',
            '23',
            '23',
            []);
        $handler = new CreateClinicHandler($repository,$readRepository);
        $handler->__invoke($command);
        $this->assertTrue($readRepository->ifExistByInnAndAddress(
            $command->getInn(),
            $command->getPostCode(),
            $command->getCity(),
            $command->getStreet(),
            $command->getBuilding()
        ));

  }
}