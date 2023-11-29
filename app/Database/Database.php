<?php

namespace Api\Database;

use PDO;
use PDOException;

/*
 * Database
 * ---------
 *
 * Static class om het werken met PDO iets te vereenvoudigen
 * De class kan uiteraard veel beter en meer functionaliteit bieden, maar
 * dit is slechts een idee voor studenten
 */
class Database
{
    private static         $connection = null;        // PDO, de connectie met de database
    private static         $statement = null;         // PDOStatement, het resultaat van een query
    private static string  $dbHost = '127.0.0.1';
    private static string  $dbUser = 'root';
    private static string  $dbPass = '';
    private static string  $dbName = 'currency-db';


   /**
    * connect
    * -------
    * Deze method is private omdat we intern in deze class de connectie met de database wel verzorgen.
    *
    * @return bool      TRUE = Connectie is gelukt, FALSE = connectie is niet gelukt.
    */
   private static function connect() : bool
    {
        if(is_null(self::$connection))
        {
            try {
               self::$connection = new PDO("mysql:host=".self::$dbHost.";dbname=".self::$dbName, self::$dbUser, self::$dbPass);
            } catch(PDOException $error) {
               return false;
            }
        }

        return true;
    }

   /**
    * query
    * -----
    * Vereenvoudigde methode om SQL-queries te versturen naar de database server.
    * Het tweede argument van deze method is niet verplicht, maar kan worden
    * gebruikt om met een array de placeholders in de SQL-statement op een veilige
    * manier te laten vervangen door de echte gegevens.
    *
    * @param string $sql         De SQL-query
    * @param array $bindings     Array met placeholders en de vervanging door echte gegevens
    *
    * @return bool               TRUE = Query is gelukt, FALSE = Query is mislukt
    */
   public static function query(string $sql, array $bindings = []) : bool
    {
       if(self::connect()) {
          self::$statement = self::$connection->prepare($sql);
          self::$statement->execute($bindings);

          return true;
       }

       return false;
    }

   /**
    * get
    * ----
    * Haalt de result set (één record) van de database server na een succesvolle query en geeft
    * de result set als een array terug
    *
    * @return array        Result set van de laatste query
    */
   public static function get() : array
    {
       if(self::connect() && !is_null(self::$statement)) {
          return self::$statement->fetch(PDO::FETCH_ASSOC);
       }

       return [];
    }

   /**
    * getAll
    * ------
    * Haalt de result set (meerdere records) van de database server na een succesvolle query en geeft
    * de result set als een array terug
    *
    * @return array        Result set van de laatste query
    */
   public static function getAll() : array
    {
       if(self::connect() && !is_null(self::$statement)) {
          return self::$statement->fetchAll(PDO::FETCH_ASSOC);
       }

       return [];
    }

   /**
    * lastInsertID
    * ------------
    * Na een insert (het toevoegen van een record) kunnen we met deze method de
    * ID vaststellen die de database toegekend heeft aan de nieuwe record.
    *
    * @return int       Laatste ID die de database heeft toegekend aan de toegevoegde record
    */
   public static function lastInsertID(): int
    {
       if(self::connect() && !is_null(self::$statement)) {
          return self::$connection->lastInsertId();
       }

       return 0;
    }
}