<?php


namespace Api\Http;


use Api\Database\Database;
use Api\Helpers\UrlParser;

class RequestParser
{
   /**
    * clients
    * -------
    * GET-request
    *
    * Method die wordt geactiveerd wanneer de command in de request gelijk is aan 'clients'
    * Geeft alle clients uit de database terug.
    *
    * BENODIGDE GEGEVENS:  Geen
    *
    * @return array        Alle clients uit de database
    */
   public static function clients(): array
   {
      Database::query('SELECT * FROM `clients`');
      return Database::getAll();
   }

   /**
    * currencies
    * ----------
    * GET-request
    *
    * Method die wordt geactiveerd wanneer de command in de request gelijk is aan 'currencies'
    * Geeft alle currencies uit de database terug.
    *
    * BENODIGDE GEGEVENS:  Geen
    *
    * @return array           Alle currencies uit de database
    */
   public static function currencies(): array
   {
      Database::query('SELECT * FROM `currencies`');
      return Database::getAll();
   }

   /**
    * wallet
    * ------
    * GET-request
    *
    * Method die wordt geactiveerd wanneer de command in de request gelijk is aan 'wallet' en daarbij als extra
    * parameter in de URL een client_id is meegegeven.
    * Geeft de wallet terug van een client.
    *
    * BENODIGDE GEGEVENS:  client_id=<client_id>
    *
    * @return array           Wallet van een client met gegeven client_id
    */
   public static function wallet(): array
   {
      $arguments = UrlParser::getArguments();

      /*
       * We hebben gegevens uit meerdere tabellen nodig, vandaar
       * JOINs in de onderstaande SQL-statement.
       */
      $sql = '
      SELECT 
         `wallet_items`.`id` AS `wallet_item_id`,
          `wallet_items`.`currency_id` AS `currency_id`,
          `wallet_items`.`bought_on` AS `bought_on`,
          `wallet_items`.`bought_value` AS `bought_value`,
          `wallet_items`.`amount` AS `amount`,
          `wallet_items`.`sold_on` AS `sold_on`,
          `wallet_items`.`sold_for_value` AS `sold_for`,
          `wallets`.`id` AS `wallet_id`,
          `currencies`.`abbr` AS `abbr`,
          `currencies`.`value` AS `current_value`,
          `currencies`.`name` AS `currency_name`,
          `currencies`.`flag` AS `currency_flag`,
          `currencies`.`country` AS `currency_country`,
          `currencies`.`unicode_symbol` AS `currency_symbol`
      FROM `wallets` 
      INNER JOIN `wallet_items` ON `wallet_items`.`wallet_id` = `wallets`.`id`
      INNER JOIN `currencies` ON `currencies`.`id` = `wallet_items`.`currency_id`
      WHERE `wallets`.`client_id` = :client_id
      ';

      Database::query($sql, [ ':client_id' => $arguments['client_id']]);
      $rows = Database::getAll();

      // Onderstaande variabele gebruiken we om een gegevensset samen te stellen met
      // database data en productiegegevens (zie hieronder)
      $result = [];
      foreach($rows as $row) {
         $row['bought_for'] = floatval($row['amount']) / floatval($row['bought_value']);
         $row['sell_for'] = floatval($row['amount'])  / floatval($row['current_value']);
         $row['profit'] = floatval($row['sell_for']) - floatval($row['bought_for']);

         $result[] = $row;
      }

      return $result;
   }

   /**
    * buy
    * ----
    * POST-request
    *
    * Deze method wordt aangeroepen wanneer de command in de request gelijk is aan 'buy'.
    * Dit is echter een POST-request en dus verwachten we dat de client de data als FORM DATA
    * naar onze API stuurt. Daardoor kunnen we in de global variabele $_POST deze gegevens benaderen.
    * Deze method voegt een nieuw item toe aan de wallet van een client.
    *
    * BENODIGDE GEGEVENS:  'currency_id'     FORM DATA
    *                      'client_id'       FORM DATA
    *                      'amount'          FORM DATA
    *
    * @return array        De data van de nieuw toegevoegde wallet item
    */
   public static function buy(): array
   {
      $arguments = UrlParser::getArguments();

      // We hebben eerst de gegevens nodig van de valuta die wordt gekocht vanwege de laatste koers
      Database::query(
         'SELECT `value` FROM `currencies` WHERE `id` = :currency_id',
         [':currency_id' => $arguments['currency_id']]
      );
      $currency = Database::get();

      // Nu moeten we de wallet van de client er bij halen en dan met name de wallet_id
      Database::query(
         "SELECT `id` AS 'wallet_id' FROM wallets WHERE `client_id` = :client_id",
         [':client_id' => $arguments['client_id']]
      );
      $wallet = Database::get();

      // Nu kunnen we een item aan de wallet toevoegen
      Database::query(
         "INSERT INTO `wallet_items`(`wallet_id`, `currency_id`, `bought_on`, `bought_value`, `amount`)
              VALUES(:wallet_id, :currency_id, :bought_on, :bought_value, :amount)",
         [
            ':wallet_id' => $wallet['wallet_id'],
            ':currency_id' => $arguments['currency_id'],
            ':bought_on' => date('Y-m-d'),
            ':bought_value' => $currency['value'],
            ':amount' => $arguments['amount']
         ]
      );

      // Achterhalen welke ID de item in de wallet heeft gekregen van de database server
      $lastInsertedID = Database::lastInsertID();
      // Want we willen de nieuwe record nu ophalen en terug geven aan de client
      Database::query(
         "SELECT * FROM `wallet_items` WHERE `id` = :lastID",
         [ ':lastID' => $lastInsertedID ]
      );

      return Database::get();
   }

   /**
    * sell
    * ----
    * POST-request
    *
    * Deze method wordt geactiveerd wanneer de command in de request gelijk is aan 'sell'
    *
    * BENODIGDE GEGEVENS:  'wallet_id'       FORM DATA
    *                      'currency_id'     FORM DATA
    *
    * @return array        De data van de nieuwe aankoop inclusief productie gegevens
    */
   public static function sell(): array
   {
      $arguments = UrlParser::getArguments();

      // Eerst de gegevens van de valuta erbij halen, want we hebben de nieuwe koers nodig
      Database::query("SELECT * FROM `currencies` WHERE `id` = :id", [ ':id' => $arguments['currency_id']]);
      $currency = Database::get();

      /*
       * Nu updaten we het record in de tabel 'wallet_items'
       */
      Database::query(
         "UPDATE `wallet_items` 
              SET `sold_on` = :sold_on, `sold_for_value` = :sold_for 
              WHERE `wallet_id` = :id AND `currency_id` = :currency_id",
         [
            ':sold_on' => date('Y-m-d'),
            ':sold_for' => $currency['value'],
            ':id' => $arguments['wallet_id'],
            ':currency_id' => $arguments['currency_id']
         ]
      );

      // De updated versie van de record opnieuw binnenhalen
      $sql = '
      SELECT 
          `wallet_items`.`id` AS `wallet_item_id`,
          `wallet_items`.`currency_id` AS `currency_id`,
          `wallet_items`.`bought_on` AS `bought_on`,
          `wallet_items`.`bought_value` AS `bought_value`,
          `wallet_items`.`amount` AS `amount`,
          `wallet_items`.`sold_on` AS `sold_on`,
          `wallet_items`.`sold_for_value` AS `sold_for`,
          `wallets`.`id` AS `wallet_id`,
          `currencies`.`abbr` AS `abbr`,
          `currencies`.`value` AS `current_value`,
          `currencies`.`name` AS `currency_name`,
          `currencies`.`flag` AS `currency_flag`,
          `currencies`.`country` AS `currency_country`,
          `currencies`.`unicode_symbol` AS `currency_symbol`
      FROM `wallet_items` 
      INNER JOIN `wallets` ON `wallet_items`.`wallet_id` = `wallets`.`id`
      INNER JOIN `currencies` ON `currencies`.`id` = `wallet_items`.`currency_id`
      WHERE `wallet_items`.`wallet_id` = :wallet_id AND `wallet_items`.`currency_id` = :currency_id
      ';

      Database::query($sql, [
         ':wallet_id' => $arguments['wallet_id'],
         ':currency_id' => $arguments['currency_id']
      ]);

      $row = Database::get();

      // Productie gegevens produceren en toevoegen aan de array
      $row['bought_for'] = floatval($row['amount']) / floatval($row['bought_value']);
      $row['sell_for'] = floatval($row['amount'])  / floatval($row['current_value']);
      $row['profit'] = floatval($row['sell_for']) - floatval($row['bought_for']);

      return $row;
   }

   /**
    * error
    * -----
    *
    * Stelt een data block samen, voor de client app, voor het verduidelijken van de error die is opgetreden
    *
    * @param int $code        HTTP-status code van de fout
    * @param string $msg      Tekstuele toelichting van de fout
    *
    * @return array           De array die aan de aanroepende code teruggegeven wordt.
    */
   public static function error(int $code, string $msg): array
   {
      return [
         'status' => $code,
         'message' => $msg
      ];
   }
}