<?php

  /**
   * Manage the environment file of the ZincPHP framework.
   * 
   */

  namespace ZincPHP\environment;

  class ZincEnvironment {

    /**
     * Cache the instance.
     * 
     * @var object $instance
     */
    private static $instance = null;

    /**
     * Cache the environment settings.
     * 
     * @var object $env
     */
    private $env = null;

    /**
     * Create a new instance of this class if not already.
     * 
     * @return object
     */
    public static function getInstance() {
      if ( ! self::$instance ) self::$instance = new \ZincPHP\environment\ZincEnvironment();
      return self::$instance;
    }

    /**
     * Read the environment file if exists.
     * 
     * @return object
     */
    public function readEnvFile() {
      if ( ! $this->env ) {
        $envPath = \App::dir('environment.json');

        // Import and set environment variables from environment document.
        if( ! file_exists( $envPath ) ) throw new Exception( 'Environment document was not found! 
        Run \'php zinc env:new\' command to create a new environment document.' );

        // Set environment settings
        $this->env = json_decode( file_get_contents( $envPath ) );
      }
      return $this->env;
    }

  }