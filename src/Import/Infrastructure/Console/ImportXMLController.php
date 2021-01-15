<?php
declare(strict_types=1);

namespace Import\Infrastructure\Console;


use DOMDocument;
use Exception;
use PDO;
use RuntimeException;
use XMLReader;

final class ImportXMLController
{
    /**
     * @var
     */
    private string $file;
    private PDO $connection;
    private PDO $statement;

    public function __construct($connection, $file)
    {

        $this->file = $file;
        $this->connection = $connection;
        $this->statement = $this->connection;
    }

    public function importXML()
    {
        $this->statement->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql_table_legal = $this->statement->prepare("INSERT INTO import_legal (inn, ogrn, full_name_licensee, form, address) VALUES (:inn, :ogrn, :full_name_licensee,:form, :address)");
        $sql_table_address = $this->statement->prepare("INSERT INTO import_post_address (inn, address,country,region,city,street, house) VALUES (:inn, :address,:country,:region,:city,:street,:house)");
        $sql_table_works = $this->statement->prepare("INSERT INTO import_works (address_id, work,number, date, termination, date_termination, information_suspension_resumption, information_cancellation, activity_type) VALUES (:address_id, :work, :number, :date, :termination, :date_termination, :information_suspension_resumption, :information_cancellation, :activity_type)");
        $doc = new DOMDocument;
        $reader = new XMLReader();

        if (file_exists($this->file)) {
            $reader->open($this->file);
            while ($reader->read()) {
                if ($reader->nodeType == XMLReader::ELEMENT) {
                    if ($reader->localName == 'licenses') {

                        $node = simplexml_import_dom($doc->importNode($reader->expand(), true));
                        $inn = $node->inn;
                        $sql_table_legal->execute([
                            ':inn' => $inn,
                            ':ogrn' => $node->ogrn,
                            ':full_name_licensee' => $node->full_name_licensee,
                            ':form' => $node->form,
                            ':address' => $node->address
                        ]);

                        foreach ($node->work_address_list->address_place as $item) {
                            try {
                                $sql_table_address->execute([
                                    ':inn' => $inn,
                                    ':address' => (string)$item->address,
                                    ':country' => (string)$item->country,
                                    ':region' => (string)$item->region,
                                    ':city' => (string)$item->city,
                                    ':street' => (string)$item->street,
                                    ':house' => (string)$item->house
                                ]);
                                $last_id = $this->connection->lastInsertId();
                            } catch (Exception $e) {
                                echo $e->getMessage();
                            }

                            foreach ($item->works->work as $value) {
                                try {
                                    $sql_table_works->execute([
                                        ':address_id' => $last_id,
                                        ':work' => (string)$value,
                                        ':number' => $node->number,
                                        ':date' => $node->date,
                                        ':activity_type' => $node->activity_type,
                                        ':termination' => $node->termination,
                                        ':date_termination' => $node->date_termination,
                                        ':information_suspension_resumption' => $node->information_suspension_resumption,
                                        ':information_cancellation' => $node->information_cancellation
                                    ]);
                                } catch (Exception $e) {
                                    echo $e->getMessage();
                                }
                            }
                        }
                    }
                }

            }
        } else {
            throw new RuntimeException('Не удалось открыть файл.');
        }


    }

    private function tableExists($dbh, $id)
    {
        $results = $dbh->query("SHOW TABLES LIKE '$id'");
        if(!$results) {
            die(print_r($dbh->errorInfo(), TRUE));
        }
        if($results->rowCount()>0){echo 'table exists';}
    }
}
