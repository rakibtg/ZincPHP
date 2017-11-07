<?php

  require_once '../inc/core_functions.php';
  require_once '../inc/core/ZincMySQL.php';
  require_once '../inc/core/ZincJWT.php';
  require_once '../inc/core/ZincValidator.php';

  class Zinc {

    public $env;        // Store environment settings.
    public $db;         // Store the db object.
    public $jwt;        // Handle JWT using this object property.
    public $validator;  // Handle user input validations.

    function __construct() {
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
      if( ! file_exists( '../environment.json' ) ) {
          \zp\return_error( 'Environment document was not found! Run \'php zinc env:new\' command to create a new environment document.' );
          exit();
      }
      // Set environment settings
      $this->env = json_decode( file_get_contents( '../environment.json' ) );
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
      $this->db = DB::getInstance( $this->env );
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

    public function bootRoute() {

      // Simple routing.
      $block = \zp\get( 'route' );
      if( empty( $block ) ) {
        $block = 'index';
      }
      // Check if block exist.
      $segments = '/'; 
      // For security purposes recasting the url splitted by segments.
      foreach( explode( '/', $block ) as $uri ) {
        $segments = $segments . $uri . '/';
      }
      $block = '../blocks' . rtrim( $segments, '/' ).'.php';
      // Search the matched block.
      if( file_exists( $block ) ) {
        // A block file was found.
        require_once $block;
      } else {
        // No block was found, return not found error.
        \zp\return_error( 'Block not found.' );
      }

    }

    // End of all methods of the Zinc class.
  }