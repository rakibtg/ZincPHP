<?php

  require "../inc/core/ZincMySQL.php";

  class Zinc {

    public $env; // Store environment settings.
    public $db;  // Store the db object.

    function __construct() {
      // Booting the framework.
      $this->bootEnvironment();
      $this->bootCors();
      $this->bootDB();
    }

    /**
     * This method will merge user environment settings with system environments.
     */
    protected function bootEnvironment() {
      global $env;
      $this->env = $env;
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
      $this->db = DB::getInstance();
    }

  }