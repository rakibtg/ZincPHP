<?php

  /**
   * Route HTTP requests to proper block.
   * 
   */

  class ZincRouter {

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
      $this->route = \zp\get( 'route' );
    }

    /**
     * Get the block name from route query string.
     * If the route query string is empty then set it to default route.
     */
    public function boot() {

      if( empty( $this->route ) ) {
        // No block was found.
        $this->goToDefaultBlock();
      } else {
        // Get the request type.
        // Check if block exist.
        $segments = '/';
        // For security purposes recasting the url splitted by segments.
        foreach( explode( '/', $this->route ) as $uri ) {
          $segments = $segments . $uri . '/';
        }
        $this->route = '../blocks' . rtrim( $segments, '/' ).'.php';
        // Search the matched block.
        if( file_exists( $this->route ) ) {
          // A block file was found.
          require_once $this->route;
        } else {
          // No block was found, return not found error.
          \zp\return_error( 'Block not found.' );
        }
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
        \zp\return_error( 'Block not found.' );
      }
    }

  }