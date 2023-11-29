<?php


namespace Api\Http;

/*
 * HttpHeader
 * ----------
 *
 * Een static class verantwoordelijk voor het versturen van de juiste headers
 * De headers moeten voorafgaand aan de data verstuurd worden naar een client.
 *
 * De class bevat constanten die kunnen worden gebruikt voor het tekstueel
 * weergeven van de status codes.
 *
 * Er is slechts 1 method in deze class, namelijk defaultHeaders
 */
class HttpHeaders
{
   // NON CODE
   public const HTTP_NO_STATUS = 0;
   // SUCCESS CODES
   public const HTTP_STATUS_OK = 200;
   public const HTTP_STATUS_CREATED = 201;
   public const HTTP_STATUS_NO_CONTENT = 204;

   // NOT OFFICIAL SUCCESS CODES
   public const HTTP_STATUS_UPDATED = 210;
   public const HTTP_STATUS_DELETED = 211;

   // ERROR CODES
   public const HTTP_STATUS_BAD_REQUEST = 400;
   public const HTTP_STATUS_UNAUTHORIZED = 401;
   public const HTTP_STATUS_FORBIDDEN = 403;
   public const HTTP_STATUS_NOT_FOUND = 404;
   public const HTTP_STATUS_METHOD_NOT_ALLOWED = 405;

   // SERVER ERROR CODES
   public const HTTP_STATUS_SERVER_ERROR = 500;
   public const HTTP_STATUS_NOT_IMPLEMENTED = 501;
   public const HTTP_STATUS_SERVICE_NOT_AVAIL = 503;


   /**
    * defaultHeaders
    * --------------
    * Stelt de juiste headers samen en zet deze klaar voor de communicatie met een client app.
    * Van de client kan dan worden verwacht dat deze juist reageert op de info in de headers.
    *
    * @param $code      int      Dit is de HTTP-status code die aangeeft wat de status is
    * @param $msg       string   Hierin kunnen we een aan de status-code verwante bericht plaatsen
    *
    * @return void      De method geeft geen data terug aan de aanroepende code.
    */
   public static function defaultHeaders(int $code = self::HTTP_STATUS_OK, string $msg = 'Ok'): void
   {
      header('Access-Control-Allow-Origin: *');    // Nodig voor CORS
      header('Content-Type: application/json');    // We moeten een client altijd vertellen in welke
                                                          // format we data terugsturen naar de client
      header("HTTP/1.1 $code $msg");               // HTTP-protocol versie en de status code
   }
}