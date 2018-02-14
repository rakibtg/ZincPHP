<?php

  require_once '../app/core/App.php';
  require_once '../app/core/ZincMySQL.php';
  require_once '../app/core/ZincJWT.php';
  require_once '../app/core/ZincValidator.php';
  require_once '../app/core/ZincHTTP.php';
  require_once '../app/core/ZincRouter.php';

  class Zinc {

    public $router;         // Route to proper blocks.

    function __construct() {

      error_reporting( E_ALL );
      ini_set( 'display_errors', 1 );

      // Setting JSON type globally.
      header( 'Content-Type: application/json; charset=utf-8' );

      // Booting the framework.
      $this->bootCors();
      $this->bootRoute();
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

    public function bootRoute() {
      $this->router = new ZincRouter;
      $this->router->boot( $this );
    }

    // End of all methods of the Zinc class.
  }
