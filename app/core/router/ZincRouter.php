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
      if ( isset( $_GET[ 'route' ] ) ) {
        $this->route = App::strTrim( $_GET[ 'route' ] );
      } else {
        $this->route = '';
      }
    }

    /**
     * Get the block name from route query string.
     * If the route query string is empty then set it to default route.
     * 
     */
    public function boot( $zincObject ) {

      /**
       * Initializing the Zinc object to the app protected varible.
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
     * Go to the block based on its request type.
     *
     */
    public function goToCurrentBlock() {

      // Request method
      $requestMethod = App::requestType();

      // Check if block exist.
      $segments = '/';
      // For security purposes recasting the url splitted by segments.
      foreach( explode( '/', $this->route ) as $uri ) {
        $segments = $segments . $uri . '/';
      }

      // Add the request type with the block name (with the basename of the block path)
      $this->blockName = '../blocks' . rtrim( $segments, '/' ).'/'.$requestMethod.'.'.basename( $segments ).'.php';

      // Search the matched block.
      if( file_exists( $this->blockName ) ) {
        // A block file was found, load the block.
        $this->loadBlock();
      } else {
        // No block was found, return not found error.
        App::responseError( 'Block not found.' );
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
        App::responseError( 'Block not found.' );
      }
    }

  }
