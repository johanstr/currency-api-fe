<?php

namespace Api\Helpers;

/*
 * UrlParser
 * ---------
 *
 * De UrlParser analyseert de data die met iedere request naar onze API gestuurd wordt. En prepareert een array
 * met de data voor gebruik in onze API
 */
class UrlParser
{
   private static string $cmd = '';          // De command die een client stuurt
   private static array $arguments = [];     // Verzameling van data die een client meestuurt

   /**
    * getCommand
    * ----------
    *
    * Geeft een string terug met de command die een client heeft gestuurd en zet de string om in
    * hoofdletters voor een uniforme afhandeling.
    *
    * @return string       De command in hoofdletters
    */
   public static function getCommand(): string
   {
      if(isset($_GET['cmd'])) {
         return (self::$cmd = strtoupper($_GET['cmd']));
      }

      return '';
   }


   /**
    * getArguments
    * ------------
    *
    * Bij veel requests naar onze API verwachten we van de client meegestuurde data. Soms vinden we
    * die data in de URL als parameter (GET) maar soms ook in een speciale body alsof het data is uit
    * een HTML-formulier (POST). Deze method haalt die data uit de request en verzameld deze in een array
    *
    * Deze method doet alleen z'n werk bij requests waar we ook data verwachten, in alle andere gevallen
    * wordt er gewoon een lege array teruggegeven
    *
    * @return array     De verzamelde data uit de request
    */
   public static function getArguments(): array
   {
      if(!empty(self::$cmd)) {            // Het heeft geen zin om actie te ondernemen als er geen command is
         self::$arguments = [];           // Sporen van een vorige request verwijderen (?) Is niet echt nodig, maar toch

         switch(self::$cmd) {
            case 'WALLET':                // GET
               self::$arguments['client_id'] = (isset($_GET['client_id']) ? intval($_GET['client_id']) :  0);
               break;

            case 'BUY':                   // POST
               self::$arguments['currency_id'] = (isset($_POST['currency_id']) ? intval($_POST['currency_id']) : 0);
               self::$arguments['client_id'] = (isset($_POST['client_id']) ? intval($_POST['client_id']) : 0);
               self::$arguments['amount'] = (isset($_POST['amount']) ? floatval($_POST['amount']) : 0.00);
               break;

            case 'SELL':                  // POST
               self::$arguments['wallet_id'] = (isset($_POST['wallet_id']) ? intval($_POST['wallet_id']) : 0);
               self::$arguments['currency_id'] = (isset($_POST['currency_id']) ? intval($_POST['currency_id']) : 0);
               break;
         }
      }

      return self::$arguments;
   }
}

