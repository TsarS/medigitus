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

    protected function setUp(): void
    {
        try {
            $this->connection = new PDO('mysql:host=localhost;dbname=rating_test', 'root', 'root');
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        $truncate = $this->connection->prepare("DELETE FROM licences");
        $truncate->execute();
        $this->file = dirname(__DIR__) . '/../../_fixtures/licences_import_test.xml';
    }

    public function testImportXML(): void
    {
        $import = new ImportXMLController($this->connection, $this->file);
        $import->importXML();
        $found = $this->connection->prepare("SELECT * FROM licences WHERE inn=:inn");
        $inn_count = $this->connection->query("SELECT COUNT(id) FROM  `licences`")->fetchColumn();;
        $address_count = $this->connection->query("SELECT COUNT(id) FROM  `licences_post_address`")->fetchColumn();;
        $works_count = $this->connection->query("SELECT COUNT(id) FROM  `licences_works`")->fetchColumn();;
        $found->execute([
            ':inn' => '6113022711'
            ]);
        $data = $found->fetch();
        $this->assertEquals('Общество с ограниченной ответственностью "Ритм-Юг"', $data["full_name_licensee"]);
        $this->assertEquals('ЛО-61-01-007957', $data["number"]);
        $this->assertEquals('Медицинская деятельность', $data["activity_type"]);
        $this->assertEquals('19',$inn_count);
        $this->assertEquals('22',$address_count);
        $this->assertEquals('393',$works_count);
    }





}