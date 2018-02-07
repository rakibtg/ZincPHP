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
        * Alias to ZincJWT class.
        * 
        */
       static public function jwt() {
         return new ZincJWT( App::environment() );
       }
    
       /**
        * Alias to send a request.
        * 
        */
       static public function makeRequest() {
         return new ZincHTTP;
       }
    
       /**
        * Alias to db.
        * 
        */
       static public function db () {
         $env = App::environment();
         if( ! empty( $env->database ) ) {
           return DB::getInstance( $env );
         }
       }
    
     }