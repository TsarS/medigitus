<?php
declare(strict_types=1);

namespace License\tests\unit\Application\Command;


use License\Application\Command\CreateLicense\CreateLicenseCommand;
use License\Application\Command\CreateLicense\CreateLicenseHandler;
use License\Application\Event\LicenseEventDispatcher;
use License\Infrastructure\Persistence\MySQL\Connection;
use License\Infrastructure\Persistence\MySQL\Hydrator;
use License\Infrastructure\Persistence\MySQL\LicenseMySQLRepository;
use License\Infrastructure\Persistence\MySQL\LicenseReadMySQLRepository;
use PHPUnit\Framework\TestCase;

final class CreateLicenseHandlerTest extends TestCase
{
    /**
     * @var LicenseMySQLRepository
     */
    protected LicenseMySQLRepository $repository;
    /**
     * @var LicenseReadMySQLRepository
     */
    protected LicenseReadMySQLRepository $readRepository;

    protected CreateLicenseCommand $command;
    /**
     * @var CreateLicenseCommand
     */
    private CreateLicenseCommand $command_second;

    protected function setUp(): void
    {
        $dbh = new Connection();
        $connection = $dbh->getConnection();
        $truncate = $connection->prepare("DELETE FROM license_address");
        $truncate->execute();
        $hydrator = new Hydrator();
        $this->repository = new LicenseMySQLRepository($connection);
        $this->readRepository = new LicenseReadMySQLRepository($connection, $hydrator);
        $this->command = new CreateLicenseCommand(
            $inn = '7729695811',
            $name = 'Клинический госпиталь на Яузе для тестирования хендлера',
            $post_address = 'Москва, Волочаевская ул, д.15, к.1',
            $country = '',
            $region = '',
            $city = '',
            $street = '',
            $house = '',
            $lat = '',
            $lon = '',
            $works = [
                ['100.1. при оказании первичной доврачебной медико-санитарной помощи в амбулаторных условиях по:', 'ФС-50-01-002470', '04.12.2020', 'Медицинская лицензия'],
                ['100.1.2. анестезиологии и реаниматологии', 'ФС-50-01-002470', '04.12.2020', 'Медицинская лицензия'],
                ['100.1.19. операционному делу', 'ФС-50-01-002470', '04.12.2020', 'Медицинская лицензия'],
                ['100.1.24. сестринскому делу', 'ФС-50-01-002470', '04.12.2020', 'Медицинская лицензия']
            ]
        );
        $this->command_second = new CreateLicenseCommand(
            $inn = '7729695811',
            $name = 'Другой госпиталь для тестирования хендлера',
            $post_address = 'Москва, Волочаевская ул, д.15, к.1',
            $country = '',
            $region = '',
            $city = '',
            $street = '',
            $house = '',
            $lat = '',
            $lon = '',
            $works = [
                ['100.1.19. несестринскому делу', 'ФС-50-01-002470', '04.12.2020', 'Медицинская лицензия']
            ]
        );

        parent::setUp();
    }


    public function testCreateLicenseHandler(): void
    {
        $handler = new CreateLicenseHandler($this->repository, $this->readRepository, new LicenseEventDispatcher());
        $handler->__invoke($this->command);
        $result = $this->readRepository->getByAddress($this->command->getPostAddress());
        $this->assertEquals($this->command->getName(),$result->getName());
    }
    /*
    public function testAddedExistingAddressToLicense() : void {
        $handler = new CreateLicenseHandler($this->repository, $this->readRepository, new LicenseEventDispatcher());
        $handler->__invoke($this->command);
        $handler_second = new CreateLicenseHandler($this->repository, $this->readRepository, new LicenseEventDispatcher());
        $handler_second->__invoke($this->command_second);

    }
    */
}