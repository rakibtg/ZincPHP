<?php

  require_once __DIR__ . '/app_traits/HelperTraits.php';
  require_once __DIR__ . '/app_traits/InputTraits.php';
  require_once __DIR__ . '/app_traits/ResponseTraits.php';
  require_once __DIR__ . '/app_traits/LibraryTraits.php';

  class App {

    use HelperTraits, InputTraits, ResponseTraits, LibraryTraits;

    /**
    * Alias to Validator class validate() method.
    *
    */
    public static function validate ( $toValid = [], $queryStringType = 'get', $exitAfterExecution = true ) {
      return ( new ZincValidator() )->validate( $toValid, $queryStringType, $exitAfterExecution );
    }

    /**
    * Alias to ZincJWT class.
    *
    */
    public static function jwt() {
      return new ZincJWT( App::environment() );
    }

    /**
    * Alias to send a request.
    *
    */
    public static function makeRequest() {
      return new ZincHTTP;
    }

    /**
    * Alias to db.
    *
    * @param $table   string    The name of the table.
    */
    public static function db ( $table = false ) {
      if ( $table ) return ZincDB::getInstance()->newQB()->table( $table );
      else return ZincDB::getInstance()->newQB();
    }

    /**
     * Log data on runtime and display instantly in the console.
     * 
     * @param  void
     * @return void
     */
    public static function console() {
      // Require the console class.
      require_once __DIR__ . '/zincphp_consoler/Console.php';
      return new Console();
    }

  }
