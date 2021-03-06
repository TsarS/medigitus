<?php
declare(strict_types=1);

namespace Import\tests\unit\Application\Command\CreateLicense;


use Import\Application\Command\CreateLicense\CreateLicenseCommand;
use Import\Application\Command\CreateLicense\CreateLicenseHandler;
use Import\Application\Event\Create\ImportEventDispatcher;
use Import\Infrastructure\Persistence\MySQL\Hydrator;
use Import\Infrastructure\Persistence\MySQL\LicenseReadMySQLRepository;
use PDO;
use PDOException;
use PHPUnit\Framework\TestCase;
use Import\Infrastructure\Persistence\MySQL\LicenseMySQLRepository;

final class CreateLicenseHandlerTest extends TestCase
{
    protected $repository;
    protected $readRepository;
    protected $command;

    protected function setUp(): void
    {
        try {
            $connection = new PDO('mysql:host=localhost;dbname=rating_test', 'root', 'root');
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $truncate = $connection->prepare("DELETE FROM license_address");
        $truncate->execute();
        $hydrator = new Hydrator();
        $this->repository = new LicenseMySQLRepository($connection);
        $this->readRepository = new LicenseReadMySQLRepository($connection, $hydrator);
        $this->command = new CreateLicenseCommand(
            $inn = '7729695811',
            $name = 'Клинический госпиталь на Яузе',
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

        parent::setUp();
    }

    public function testCreateLicenseInHandler(): void
    {
        $handler = new CreateLicenseHandler($this->repository, $this->readRepository, new ImportEventDispatcher());
        $handler->__invoke($this->command);
        $result = $this->readRepository->addressExist($this->command->getPostAddress());
        $this->assertTrue($result);
    }

    public function testCreateLicenseInHandlerIfClinicExist(): void
    {
        $handler = new CreateLicenseHandler($this->repository, $this->readRepository, new ImportEventDispatcher());
        $handler->__invoke($this->command);
        $command2 = new CreateLicenseCommand(
            $inn = '7729695811',
            $name = 'Клинический госпиталь на Яузе',
            $post_address = 'Москва, Волочаевская, 15к.1',
            $country = '',
            $region = '',
            $city = '',
            $street = '',
            $house = '',
            $lat = '',
            $lon = '',
            $works = [
                ['Добавлено к основным', 'ФС-50-01-002470', '04.12.2020', 'Медицинская лицензия']
            ]
        );
        $handler = new CreateLicenseHandler($this->repository, $this->readRepository, new ImportEventDispatcher());
        $handler->__invoke($command2);
    }

    public function testAddWorksIfAlreadyExist(): void
    {
        $handler = new CreateLicenseHandler($this->repository, $this->readRepository, new ImportEventDispatcher());

        $handler->__invoke($this->command);
        $command = new CreateLicenseCommand(
            $inn = '2221243213',
            $name = 'Клинический госпиталь на Яузе',
            $post_address = 'Москва, Волочаевская, 15к.1',
            $country = 'Российская Федерация',
            $region = 'Россия',
            $city = 'Москва',
            $street = 'Волочаевская',
            $house = '1',
            $lat = '',
            $lon = '',
            $works = [
                ['100.1.24. сестринскому делу', 'ФС-50-01-002470', '04.12.2020', 'Медицинская лицензия']
            ]
        );
        $handler = new CreateLicenseHandler($this->repository, $this->readRepository, new ImportEventDispatcher());
        $handler->__invoke($command);
        $result = $this->readRepository->getByAddress($post_address);
        $this->assertCount(4, $result->getWorks());
    }


}