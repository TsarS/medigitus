<?php
declare(strict_types=1);

use Import\Infrastructure\Console\ImportXMLController;
require __DIR__ . '/../vendor/autoload.php';





$file = dirname(__DIR__).'/data/xml/licences.xml';
try {
    $connection = new PDO('mysql:host=localhost;dbname=rating', 'root', 'root');
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
$script_start = microtime(true);
$import = new ImportXMLController($connection, $file);
$import->importXML();
echo '<br>===============================================================';
echo 'Время выполнения скрипта: ' . (microtime(true) - $script_start) . ' sec.';
echo '<br>===============================================================';
echo 'Заняло памяти: '.memory_get_usage()/1024 .' Mb';





