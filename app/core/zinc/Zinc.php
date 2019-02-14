<?php

  namespace ZincPHP\Zinc;

  require_once __DIR__ . '/../environment/ZincEnvironment.php';
  require_once __DIR__ . '/../intellect/App.php';
  require_once __DIR__ . '/../database/ZincDB.php';
  require_once __DIR__ . '/../database/ZincModel.php';
  require_once __DIR__ . '/../jwt/ZincJWT.php';
  require_once __DIR__ . '/../validator/ZincValidator.php';
  require_once __DIR__ . '/../http_requests/ZincHTTP.php';
  require_once __DIR__ . '/../router/ZincRouter.php';
  require_once __DIR__ . '/../input/ZincInput.php';
  require_once __DIR__ . '/../response/ZincResponse.php';
  require_once __DIR__ . '/../string/ZincString.php';

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
      $env = \App::environment();
      $requestMethod = strtolower( trim( $_SERVER[ 'REQUEST_METHOD' ] ) );

      if( ! empty( $env->cors_allowed ) ) {
        if( isset( $_SERVER[ 'HTTP_ORIGIN' ] ) ) {
          $http_origin = $_SERVER[ 'HTTP_ORIGIN' ];
          foreach( $env->cors_allowed as $_dmn ) {
            if( $http_origin == $_dmn ) {
              header( 'Access-Control-Allow-Origin: ' . $http_origin );
              header( 'Access-Control-Allow-Methods: ' . 'GET, POST, PUT, DELETE, PATCH, OPTIONS' );
              header( 'Access-Control-Allow-Headers: Origin, Content-Type, Authorization' );
              if ( $requestMethod == 'options' ) {
                // This request is a CORS preflight.
                \App::response()
                  ->data( '' )
                  ->send();
              }
            }
          }
        }
      }
    }

    public function bootRoute() {
      $this->router = new \ZincPHP\Route\ZincRouter;
      $this->router->boot( $this );
    }

    // End of all methods of the Zinc class.
  }
