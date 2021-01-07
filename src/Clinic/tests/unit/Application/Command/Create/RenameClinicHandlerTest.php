<?php
declare(strict_types=1);

namespace Application\Command\Create;


use Clinic\Application\Command\Rename\RenameClinicCommand;
use Clinic\Application\Command\Rename\RenameClinicHandler;
use Clinic\Application\Event\Create\ClinicEventDispatcher;
use Clinic\Infrastructure\Persistence\Hydrator;
use Clinic\Infrastructure\Persistence\MySQL\ClinicMySQLRepository;
use Clinic\Infrastructure\Persistence\MySQL\ClinicReadMySQLRepository;
use Clinic\tests\unit\Domain\Entity\CreateClinicBuilder;
use Exception;
use PDO;
use PDOException;
use PHPUnit\Framework\TestCase;

final class RenameClinicHandlerTest extends TestCase
{

    public function testRenameClinicHandler(): void
    {
        try {
            $connection = new PDO('mysql:host=localhost;dbname=rating_test', 'root', 'root',
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_STRINGIFY_FETCHES => false,
                    PDO::ATTR_EMULATE_PREPARES => false]);
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        $connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $connection->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, false);
        $hydrator = new Hydrator();
        $repository = new ClinicMySQLRepository($connection);
        $readRepository = new ClinicReadMySQLRepository($connection, $hydrator);
        $dispatcher = new ClinicEventDispatcher();
        $handler = new RenameClinicHandler($repository, $readRepository, $dispatcher);

        $clinic = (new CreateClinicBuilder())->build();
        try {
            $repository->add($clinic);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        $rename = new RenameClinicCommand(
            $clinic->getId()->getId(),
            $newName = 'Переименновая клиника в хендлере',
        );
        $handler->__invoke($rename);
        $testAfterRename = $readRepository->get($clinic->getId());
        $this->assertEquals($newName, $testAfterRename->getName()->getName());


    }
}