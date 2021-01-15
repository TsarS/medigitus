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
    protected $inn;
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
        $this->inn = '2221243213';
    }

    public function testImportXML(): void
    {
        $this->found = $this->connection->prepare("SELECT * FROM import_legal WHERE inn=:inn");
        $this->found->execute([
            ':inn' => $this->inn
        ]);
        $data = $this->found->fetch();
        $this->assertEquals('Общество с ограниченной ответственностью "КЛИНИКА НОРМА"', $data["full_name_licensee"]);
        $inn_count = $this->connection->query("SELECT COUNT(id) FROM  import_legal")->fetchColumn();
        $this->assertEquals('5', $inn_count);
        $this->assertEquals('Общество с ограниченной ответственностью "КЛИНИКА НОРМА"', $data["full_name_licensee"]);
        $this->assertEquals('2221243213', $data["inn"]);
        $this->assertEquals('656039, Россия, Алтайский край, г. Барнаул, ул. Телефонная, д. 165', $data["address"]);
    }
    public function testImportPostAddress() :void {
        $this->found = $this->connection->prepare("SELECT * FROM import_post_address WHERE inn=:inn");
        $this->found->execute([
            ':inn' => $this->inn
        ]);
        $data = $this->found->fetch();
        $address_count = $this->connection->query("SELECT COUNT(id) FROM  import_post_address")->fetchColumn();;
        $this->assertEquals('5', $address_count);
        $this->assertEquals($this->inn, $data['inn']);
        $this->assertEquals('656039, Алтайский край, г. Барнаул, ул. Телефонная, д. 165', $data['address']);
    }

/*
    public function testImportWorks(): void {

        print_r('testImportWorks='.self::$address_id);

        $this->found = $this->connection->prepare("SELECT * FROM import_works WHERE address_id=:address_id");
       $this->found->execute([
           ':address_id' => self::$address_id
       ]);

       $works_count = $this->connection->query("SELECT COUNT(id) FROM  import_works")->fetchColumn();
       $data = $this->found->fetch();



      $this->assertEquals('73', $works_count);
       $this->assertEquals('ЛО-61-01-007957', $data["number"]);
       $this->assertEquals('04.12.2020', $data["date"]);
      // $this->assertEquals('ЛО-61-01-007957', $data["activity_type"]);
       $this->assertEquals('Медицинская деятельность', $data["activity_type"]);

   }
*/



}