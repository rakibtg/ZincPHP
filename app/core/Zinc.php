<?php

  require_once '../app/core/App.php';
  require_once '../app/core/ZincHelpers.php';
  require_once '../app/core/ZincMySQL.php';
  require_once '../app/core/ZincJWT.php';
  require_once '../app/core/ZincValidator.php';
  require_once '../app/core/ZincHTTP.php';
  require_once '../app/core/ZincRouter.php';

  class Zinc {

    public $env;            // Store environment settings.
    public $db;             // Store the db object.
    public $jwt;            // Handle JWT using this object property.
    public $validator;      // Handle user input validations.
    public $httpRequest;    // Do HTTP requests.
    public $router;         // Route to proper blocks.

    function __construct() {

      error_reporting( E_ALL );
      ini_set( 'display_errors', 1 );

      // Setting JSON type globally.
      header( 'Content-Type: application/json; charset=utf-8' );

      // Booting the framework.
      $this->bootEnvironment();
      $this->bootCors();
      $this->bootDB();
      $this->bootValidator();
      $this->bootJWT();
      $this->bootRoute();
    }

    /**
     * This method will merge user environment settings with system environments.
     */
    protected function bootEnvironment() {
      // Import and set environment variables from environment document.
      if( ! file_exists( '../app/environment.json' ) ) {
          \zp\response_error( 'Environment document was not found! Run \'php zinc env:new\' command to create a new environment document.' );
          exit();
      }
      // Set environment settings
      $this->env = json_decode( file_get_contents( '../app/environment.json' ) );
      // Append document root with env variable.
      $this->env->document_root = $_SERVER[ 'DOCUMENT_ROOT' ]; 
    }

    /**
     * This method will allow specific domain for Cross-origin resource sharing.
     */
    public function bootCors() {
      if( ! empty( $this->env->cors_allowed ) ) {
        if( isset( $_SERVER[ 'HTTP_ORIGIN' ] ) ) {
          $http_origin = $_SERVER[ 'HTTP_ORIGIN' ];
          foreach( $this->env->cors_allowed as $_dmn ) {
            if( in_array ( $http_origin, $_dmn ) ) {  
              header("Access-Control-Allow-Origin: $http_origin");
            }
          }
        }
      }
    }

    /**
     * This method will create a instance of the simple mysql orm.
     */
    public function bootDB() {
      if( ! empty( $this->env->database ) ) {
        $this->db = DB::getInstance( $this->env );
      }
    }

    /**
     * This method will create an instance of zinc validator class.
     * This class will be use to validate user requests.
     */
    public function bootValidator() {
      $this->validator = new ZincValidator();
    }

    /**
     * Instantiating Zinc JWT( JSON Web Token ).
     */
    public function bootJWT() {
      $this->jwt = new ZincJWT( $this->env );
    }

    /**
     * Instantiating Zinc HTTP request module.
     */
    public function bootHTTPReques() {
      $this->httpRequest = new ZincHTTP;
    }

    public function bootRoute() {
      $this->router = new ZincRouter;
      $this->router->boot( $this );
    }

    // End of all methods of the Zinc class.
  }