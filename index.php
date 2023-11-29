<?php declare(strict_types=1);
/*
 * Onderstaande code vangt de OPTIONS request op van een browser in het kader van CORS en reageert
 * daar op. Voor dat de request vanuit JavaScript verstuurd wordt door de browser naar een API stuurt deze altijd
 * eerst een OPTIONS-request, vandaar dat deze eerst moet worden afgehandeld.
 */
if (isset($_SERVER['HTTP_ORIGIN'])) {
    // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
    // you want to allow, and if so:
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        // may also be using PUT, PATCH, HEAD etc
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

@include_once('vendor/autoload.php');

/*
 * In plaats van includes of requires maken we gebruik van de moderne namespace en use statements
 * Door de autoload.php nog wel te includen zijn we in staat op deze manier te werken.
 */
use Api\Helpers\UrlParser;             // Parsed de request van een client en stelt een array samen met belangrijke request data
use Api\Http\HttpHeaders;              // Versturen van de juist geformateerde headers
use Api\Http\RequestParser;            // Na de UrlParser wordt iedere request hier in feite afgehandeld en de data samengesteld

// Dit is de variabele waarin we de terug te sturen data opvangen vanuit de RequestHandler
$response_data = [];

/*
 * Met de UrlParser achterhalen we eerst de command (dus wat wil de client van ons)
 */
switch(UrlParser::getCommand()) {
   case 'CLIENTS':                                    // GET-request, geef alle clients in de database terug
      HttpHeaders::defaultHeaders();
      echo json_encode(RequestParser::clients());     // RequestParser geeft altijd een array terug, dus hier eerst omvormen naar een JSON-string
      break;

   case 'CURRENCIES':                                 // GET-request, geef alle currencies in de database terug
      HttpHeaders::defaultHeaders();
      echo json_encode(RequestParser::currencies());
      break;

   case 'WALLET':                                     // GET-request, geef de wallet van een client terug
      HttpHeaders::defaultHeaders();
      echo json_encode(RequestParser::wallet());
      break;

   case 'BUY':                                        // POST-request, verwerk het kopen van een currency in de database
      HttpHeaders::defaultHeaders();
      echo json_encode(RequestParser::buy());
      break;

   case 'SELL':
      HttpHeaders::defaultHeaders();                  // POST-request, verwerk het verkopen van een currency in de database
      echo json_encode(RequestParser::sell());
      break;

   default:                                           // Standaard gedrag, oftewel de request wordt niet door onze API ondersteund
      HttpHeaders::defaultHeaders(HttpHeaders::HTTP_STATUS_BAD_REQUEST, 'Request not allowed');
      echo json_encode(RequestParser::error(HttpHeaders::HTTP_STATUS_BAD_REQUEST, 'Request not allowed or not supported'));
      break;
}