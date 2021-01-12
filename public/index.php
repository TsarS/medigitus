<?php
declare(strict_types=1);

use Import\Infrastructure\Console\ImportXMLController;
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
$data = $clinics->showClinics();

print_r($data);
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





