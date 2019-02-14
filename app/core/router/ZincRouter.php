<?php

  namespace ZincPHP\Route;

  /**
   * Route HTTP requests to proper block.
   *
   */

  class ZincRouter {

  /**
   * The entire app object, that contains every ZincPHP methods.
   * Zinc router(this class) will not be a part of this app object.
   * 
   * @var object $app
   */
    protected $app;

    /**
     * Current block name.
     * @var string
     */
    public $blockName;

    /**
     * Current route query string data.
     * @var string
     */
    public $route;

    function __construct() {
      // Get the current route path.
      $this->route = \App::strTrim( $this->fetchUrl() );
    }

    /**
     * Get the block name from route query string.
     * If the route query string is empty then set it to default route.
     * 
     */
    public function boot( $zincObject ) {

      /**
       * Initializing the Zinc object to the app protected variable.
       * So, every features are accessible from the route.
       */
      $this->app = $zincObject;

      if( empty( $this->route ) ) {
        // No block was given.
        $this->goToDefaultBlock();
      } else {
        // Block was detected in the query string.
        $this->goToCurrentBlock();
      }
    }

    /**
     * Fetch destination from the URL.
     * 
     * @return  string  URI Segments
     */
    public function fetchUrl() {
      // If we dont use Apache/Ngnix then we will get the URI from PATH_INFO
      if( isset( $_SERVER[ 'PATH_INFO' ] ) ) {
        if( ! empty( $_SERVER[ 'PATH_INFO' ] ) ) return $_SERVER[ 'PATH_INFO' ];
      }
      // If we use clean url then lets use the REQUEST_URI
      if( isset( $_SERVER[ 'REQUEST_URI' ] ) ) {
        if( ! empty( $_SERVER[ 'REQUEST_URI' ] ) ) {
          $uri = $_SERVER[ 'REQUEST_URI' ];
          // Remove trailing index.php
          $prefix = "/index.php";
          if ( substr( $uri, 0, strlen( $prefix ) ) == $prefix ) {
            $uri = substr( $uri, strlen( $prefix ) );
          }
          // Remove query strings from the URL
          $uri = explode( '?', $uri )[ 0 ];
          return $uri == '/' ? '' : $uri;
        }
      }
      return ''; // Finally return empty string, if no URI segments was found.
    }

    public function initializeMiddleware() {
      $definations = \App::dir('middlewares') 
        . '/' 
        . 'init.middleware.php';
      if(file_exists($definations)) {
        require_once $definations;
        if(isset($init)) { // $init variable lives in the init.middleware.php file.
          return $init;
        }
      }
      return false;
    }

    public function handleMiddleware($segments) {
      $init = $this->initializeMiddleware();
      if( $init !== false ) {
        $currentBlock = trim(\App::string($segments)->trim('/'));
        if(isset($init[$currentBlock])) {
          foreach($init[$currentBlock] as $middlewareFile) {
            // Include the middleware function.
            require_once \App::dir('middlewares') 
              . '/' 
              . $middlewareFile 
              . '.php';
            // Call the middleware function.
            ($middlewareFile)();
          }
        }
      }
    }

    /**
     * Go to the block based on its request type.
     *
     */
    public function goToCurrentBlock() {

      // Request method
      $requestMethod = \App::requestType();

      // Check if block exist.
      $segments = '/';
      // For security purposes recasting the url splitted by segments.
      foreach( explode( '/', $this->route ) as $uri ) {
        $segments = $segments . $uri . '/';
      }

      // Remove extra // from the segments.
      $segments = \App::string($segments)
        ->trim('/')
        ->prepend('/');

      // Add the request type with the block name (with the basename of the block path)
      $this->blockName = 
        \App::dir('blocks') 
          . $segments 
          . '/' 
          . $requestMethod
          . '.'
          . basename( $segments )
          . '.php';

      // Search the matched block.
      if( file_exists( $this->blockName ) ) {
        // Handle middlwares.
        $this->handleMiddleware($segments);
        // A block file was found, load the block.
        $this->loadBlock();
      } else {
        // No block was found, return not found error.
        \App::response()
          ->data( 'Block not found.' )
          ->error()
          ->pretty()
          ->send();
      }
    }

    /**
     * Load the default block.
     * @param   none
     * @return  none
     *
     */
    public function goToDefaultBlock() {
      // Set default block path.
      $this->blockName = '../blocks/index/get.index.php';
      // Load the default block.
      $this->loadBlock();
    }

    /**
     * Load a block.
     * @param   none
     * @return  none
     *
     */
    public function loadBlock() {
      if( file_exists( $this->blockName ) ) {
        // The block exists.
        require_once $this->blockName;
      } else {
        // No block was found, return not found error.
        \App::response()->data( 'Block not found.' )->error()->pretty()->send();
      }
    }

  }
