<?php

  namespace ZincPHP\Input;
  use \Illuminate\Http\Request;

  /**
   * ZincInput is a helper class of ZincPHP framework that 
   * that utilizes the "Illuminate Http" package to receive user inputs.
   * 
   */

  class ZincInput {

    /**
     * Cache the ZincInput instance.
     * 
     * @var object $instance
     */
    private static $instance = null;

    /**
     * Cache the Illuminate Http instance.
     * 
     * @var object $_http
     */
    private $_http = null;

    public static function getInstance() {
      if( ! self::$instance ) self::$instance = new ZincInput();
      return self::$instance;
    }

    public function provider() {
      if( ! $this->_http ) {
        $this->_http = Request::createFromGlobals();
      }
      return $this->_http;
    }

  }