<?php

  require_once __DIR__ . '/app_traits/HelperTraits.php';
  require_once __DIR__ . '/app_traits/InputTraits.php';
  require_once __DIR__ . '/app_traits/ResponseTraits.php';

  class App {

    use HelperTraits, InputTraits, ResponseTraits;

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
    */
    public static function db () {
      $env = App::environment();
      if( ! empty( $env->database ) ) {
        return DB::getInstance( $env );
      }
    }

  }