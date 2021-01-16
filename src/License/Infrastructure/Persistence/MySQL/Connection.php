<?php
declare(strict_types=1);

namespace License\Infrastructure\Persistence\MySQL;


use PDO;
use PDOException;

final class Connection
{
    private PDO $connection;

   public function __construct()
   {
       try {
           $this->connection = new PDO('mysql:host=localhost;dbname=rating_test', 'root', 'root');
       } catch (PDOException $e) {
           print "Error!: " . $e->getMessage() . "<br/>";
           die();
       }
       $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   }
   public function getConnection() : PDO {
       return $this->connection;
   }
}