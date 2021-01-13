<?php
declare(strict_types=1);

use Import\Application\Command\CreateLicense\CreateLicenseCommand;
use Import\Application\Command\CreateLicense\CreateLicenseHandler;
use Import\Infrastructure\Persistence\MySQL\Hydrator;
use Import\Infrastructure\Persistence\MySQL\LicenseMySQLRepository;
use Import\Infrastructure\Persistence\MySQL\LicenseReadMySQLRepository;
use Import\Infrastructure\Web\LicenseController;

require __DIR__ . '/../vendor/autoload.php';





$file = dirname(__DIR__).'/data/xml/licences.xml';
try {
    $connection = new PDO('mysql:host=localhost;dbname=rating_test', 'root', 'root');
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
$clinics = new LicenseController($connection);
$data = $clinics->showClinicsWithLicence();

$hydrator = new Hydrator();
$repository = new LicenseMySQLRepository($connection);
$readRepository = new LicenseReadMySQLRepository($connection, $hydrator);


foreach ($data as $item) {

    $handler = new CreateLicenseHandler($repository, $readRepository);
    $works = $clinics->getWorksByAddress($item["id"]);
    $handler->__invoke(new CreateLicenseCommand(
        $item["inn"],
        $item["address"],
        $works
    ));
}
/*
 * foreach ($clinics as $clinic) {
            $sql_works->execute([':address_id'=> $clinic["id"]]);
            $works = $sql_works->fetchAll();
            echo '</br>';
            echo 'ИНН= '.$clinic["inn"].'</br>'.'Название= '.$clinic["full_name_licensee"].'</br>'.'Почтовый адрес = '.$clinic["address"].'</br>';
            foreach ($works as $work) {
            //    print_r($works);
                echo $work["work"]." ".$work["number"]." ".$work["date"];
                echo '</br>';
            }
            echo '__________________________________________________';
        }
 */


//print_r($data);
/*
foreach ($data as $item) {
    echo '<p class = "login">', $item['full_name_licensee'] , '</p>';
    echo '<p class = "login">', $item['address'] , '</p>';
  //  print_r($item);
}
*/





/*
$script_start = microtime(true);
$import = new ImportXMLController($connection, $file);
$import->importXML();
echo '<br>===============================================================';
echo 'Время выполнения скрипта: ' . (microtime(true) - $script_start) . ' sec.';
echo '<br>===============================================================';
echo 'Заняло памяти: '.memory_get_usage()/1024 .' Mb';
*/





