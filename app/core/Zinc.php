<?php

  require_once __DIR__ . '/ZincEnvironment.php';
  require_once __DIR__ . '/App.php';
  require_once __DIR__ . '/ZincMySQL.php';
  require_once __DIR__ . '/ZincJWT.php';
  require_once __DIR__ . '/ZincValidator.php';
  require_once __DIR__ . '/ZincHTTP.php';
  require_once __DIR__ . '/ZincRouter.php';

  class Zinc {

    public $router;         // Route to proper blocks.

    function __construct() {

      // Error reporting will be re-thinked later.
      error_reporting( E_ALL );
      ini_set( 'display_errors', 1 );

      // Booting the framework.
      $this->bootCors();
      $this->bootRoute();
    }

    /**
     * This method will allow specific domain for Cross-origin resource sharing.
     */
    public function bootCors() {
      $env = App::environment();
      $requestMethod = strtolower( trim( $_SERVER[ 'REQUEST_METHOD' ] ) );

      if( ! empty( $env->cors_allowed ) ) {
        if( isset( $_SERVER[ 'HTTP_ORIGIN' ] ) ) {
          $http_origin = $_SERVER[ 'HTTP_ORIGIN' ];
          foreach( $env->cors_allowed as $_dmn ) {
            if( $http_origin == $_dmn ) {
              header( 'Access-Control-Allow-Origin: ' . $http_origin );
              header( 'Access-Control-Allow-Methods: ' . 'GET, POST, PUT ,DELETE' );
              header( 'Access-Control-Allow-Headers: Origin, Content-Type, Authorization' );
              if ( $requestMethod == 'options' ) {
                // This request is a CORS preflight.
                App::response('');
              }
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
