<?php
declare(strict_types=1);

namespace Import\tests\unit\Infrastructure\Console;


use Import\Infrastructure\Console\ImportXMLController;
use PDO;
use PDOException;
use PHPUnit\Framework\TestCase;

final class ImportXMLControllerTest extends TestCase

{
    protected $connection;
    protected $file;
    protected $file_one;
    protected $file_short;
    protected $file_test;
    protected $file_long;
    protected $import;
    protected $found;
    protected static $inn = '5009004418';
    protected static $post_address = '142046, Россия, Московская область, г. Домодедово, территория "Зеленая роща-Сонино"';
    protected static $name = 'Федеральное казенное учреждение здравоохранения "Санаторий "Зеленая роща" Министерства внутренних дел Российской Федерации"';
    protected $path;
    protected static $address_id;

    protected function setUp(): void
    {
        /** Подключение и очистка базы данных */
        try {
            $this->connection = new PDO('mysql:host=localhost;dbname=rating_test', 'root', 'root');
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        $truncate = $this->connection->prepare("DELETE FROM import_legal");
        $truncate->execute();

        /**
         * Подключение файла для тестов. В зависимости от файла = разные результаты
         */

        $this->path = dirname(__DIR__) . '/../../_fixtures/';
        $this->file_one = 'licences_import_test_one.xml';
        $this->file_short = 'licences_import_test_short.xml';
        $this->file_test = 'licences_import_test.xml';
        $this->file_long = 'licences_import_test_long.xml';

        $this->file = $this->path.$this->file_one;


        $this->import = new ImportXMLController($this->connection, $this->file);
        $this->import->importXML();
    }

    public function testImportXML(): void
    {
        $this->found = $this->connection->prepare("SELECT * FROM import_legal WHERE inn=:inn");
        $this->found->execute([':inn' => self::$inn]);
        $data = $this->found->fetch();
        $this->assertEquals(self::$inn, $data["inn"]);
     //   $this->assertEquals(preg_split('/\r\n|\r|\n/',addslashes(self::$name)),preg_split('/\r\n|\r|\n/',addslashes($data["full_name_licensee"])));
    //    $this->assertEquals(addslashes(self::$post_address), addslashes($data["post_address"]));
    }

    public function testImportPostAddress() :void {
        $this->found = $this->connection->prepare("SELECT * FROM import_post_address WHERE inn=:inn");
        $this->found->execute([':inn' => self::$inn]);
        $data = $this->found->fetch();
        $this->assertEquals(self::$inn, $data['inn']);
      //  $this->assertEquals(addslashes(self::$post_address), addslashes($data['address']));
    }
}