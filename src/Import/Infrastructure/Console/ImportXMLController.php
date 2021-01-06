<?php
declare(strict_types=1);

namespace Import\Infrastructure\Console;


use DOMDocument;
use Exception;
use RuntimeException;
use XMLReader;

final class ImportXMLController
{
    private $file;
    private $connection;

    public function __construct($connection, $file)
    {

        $this->file = $file;
        $this->connection = $connection;
    }

    public function importXML()
    {
        $stmt = $this->connection;
        $sql_table_legal = $stmt->prepare("INSERT INTO licences (inn, ogrn, full_name_licensee, number, date, termination, date_termination, information_suspension_resumption, information_cancellation, activity_type) VALUES (:inn, :ogrn, :full_name_licensee, :number, :date, :termination, :date_termination, :information_suspension_resumption, :information_cancellation, :activity_type)");
        $sql_table_address = $stmt->prepare("INSERT INTO licences_post_address (inn, address) VALUES (:inn, :address)");
        $sql_table_works = $stmt->prepare("INSERT INTO licences_works (address_id, work) VALUES (:address_id, :work)");
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
                            ':number' => $node->number,
                            ':date' => $node->date,
                            ':activity_type' => $node->activity_type,
                            ':termination' => $node->termination,
                            ':date_termination' => $node->date_termination,
                            ':information_suspension_resumption' => $node->information_suspension_resumption,
                            ':information_cancellation' => $node->information_cancellation
                        ]);

                        foreach ($node->work_address_list->address_place as $item) {
                            try {
                                $sql_table_address->execute([
                                    'inn' => $inn,
                                    'address' => (string)$item->address
                                ]);
                                $last_id = $this->connection->lastInsertId();
                            } catch (Exception $e) {
                                echo $e->getMessage();
                            }

                            foreach ($item->works->work as $value) {
                                try {
                                    $sql_table_works->execute([
                                        ':address_id' => $last_id,
                                        ':work' => (string)$value
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
}
