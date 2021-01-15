<?php
declare(strict_types=1);

use Import\Application\Command\CreateLicense\CreateLicenseCommand;
use Import\Application\Command\CreateLicense\CreateLicenseHandler;
use Import\Infrastructure\Persistence\MySQL\Hydrator;
use Import\Infrastructure\Persistence\MySQL\LicenseMySQLRepository;
use Import\Infrastructure\Persistence\MySQL\LicenseReadMySQLRepository;
use Import\Infrastructure\Web\LicenseController;

require __DIR__ . '/../vendor/autoload.php';

try {
    $connection = new PDO('mysql:host=localhost;dbname=rating_test', 'root', 'root');
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
$hydrator = new Hydrator();
$repository = new LicenseMySQLRepository($connection);
$readRepository = new LicenseReadMySQLRepository($connection, $hydrator);




$clinics = new LicenseController($connection);
$data = $clinics->showClinicsWithLicense();

foreach ($data as $item) {
    $handler = new CreateLicenseHandler($repository, $readRepository);
    $works = $clinics->getWorksByAddress($item["id"]);
    $handler->__invoke(new CreateLicenseCommand(
        $item["inn"],
        $item["full_name_licensee"],
        $item["address"],
        $item["country"],
        $item["region"],
        $item["city"],
        $item["street"],
        $item["house"],
        $works
    ));
}






/*
$script_start = microtime(true);
$import = new ImportXMLController($connection, $file);
$import->importXML();
echo '<br>===============================================================';
echo 'Время выполнения скрипта: ' . (microtime(true) - $script_start) . ' sec.';
echo '<br>===============================================================';
echo 'Заняло памяти: '.memory_get_usage()/1024 .' Mb';
*/





