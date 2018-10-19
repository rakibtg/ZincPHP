<?php

  require_once __DIR__ . '/intellect_traits/HelperTraits.php';
  require_once __DIR__ . '/intellect_traits/InputTraits.php';
  require_once __DIR__ . '/intellect_traits/ResponseTraits.php';
  require_once __DIR__ . '/intellect_traits/LibraryTraits.php';
  require_once __DIR__ . '/intellect_traits/DatabaseTraits.php';

  class App {

    use HelperTraits, InputTraits, 
        ResponseTraits, LibraryTraits, DatabaseTraits;

    /**
    * Alias to Validator class validate() method.
    *
    */
    public static function validate ( $toValid = [], $exitAfterExecution = true ) {
      return ( new \ZincPHP\validator\ZincValidator() )->validate( $toValid, $exitAfterExecution );
    }

    /**
    * Alias to ZincJWT class.
    *
    */
    public static function JWT() {
      return new \ZincPHP\core\ZincJWT();
    }

    /**
    * Alias to send a request.
    *
    */
    public static function makeRequest() {
      return new \ZincPHP\http\ZincHTTP;
    }

    /**
    * Alias to db.
    *
    * @param $table   string    The name of the table.
    */
    public static function db( $table = false, $provider = false ) {
      if( $table ) {
        return \ZincPHP\Database\ZincDB::getInstance()
          ->provider()
          ->getConnection()
          ->table( $table );
      } else if( $provider === true ) {
        return \ZincPHP\Database\ZincDB::getInstance()
          ->provider();
      } else {
        return \ZincPHP\Database\ZincDB::getInstance()
          ->provider()
          ->getConnection();
      }
    }

    /**
     * Boot a model.
     * 
     */
    public static function bootModel() {
      \ZincPHP\Database\ZincDB::bootModel();
    }

    /**
     * Alias for database schema methods.
     *
     */
    public static function schema() {
      return self::db( $table = false, $provider = true )
        ->schema();
    }

    /**
     * Returns a new connection each time.
     *
     */
    public static function RAWConnection() {
      return \ZincPHP\Database\ZincDB::freshConnection();
    }

    /**
     * Returns a seeder connection each time.
     *
     */
    public static function seed( $table ) {
      return self::RAWConnection()
        ->table( $table );
    }

    /**
     * Log data on runtime and display instantly in the console.
     * 
     * @param  void
     * @return void
     */
    public static function console() {
      // Require the console class.
      require_once __DIR__ . '/../cli/zincphp_consoler/Console.php';
      // return new Console();
      return new \ZincPHP\Console\Console();
    }

  }
