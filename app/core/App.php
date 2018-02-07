<?php
 
  require_once '../app/core/Traits/HelperTraits.php';
  
  class App {
 
    /**
     * Alias to Validator class validate() method.
     * 
     */
    static public function validate ( $toValid = [], $queryStringType = 'get', $exitAfterExecution = true ) {
      return ( new ZincValidator() )->validate( $toValid, $queryStringType, $exitAfterExecution );
    }
 
    /**
     * Get all the environments data.
     * 
     * @return array App settings; JSON document as array.
     */
    static public function environment() {
      // Import and set environment variables from environment document.
      if( ! file_exists( '../app/environment.json' ) ) {
        \zp\response_error( 'Environment document was not found! Run \'php zinc env:new\' command to create a new environment document.' );
        exit();
      }
      // Set environment settings
      return json_decode( file_get_contents( '../app/environment.json' ) );
    }
 
  }