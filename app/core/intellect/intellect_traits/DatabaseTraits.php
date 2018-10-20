<?php
  trait DatabaseTraits {

    /**
     * Importing a database table model in your code.
     * 
     */
    public static function model( $modelPath = '' ) {
      if(empty( $modelPath )) throw new Exception( "Model name can't be empty" );

      $modelPath = trim(( string ) $modelPath );
      if( $modelPath[ 0 ] !== '/' ) $modelPath = '/' . $modelPath;

      // Generate the namespace of the model.
      $modelNamespace = 'ZincPHP\models' . str_replace( '/', '\\', $modelPath ) . '\\';

      // Generate the absolute path of the model file.
      $modelPath = self::dir( 'models' ) . $modelPath;
      $modelClassName = basename( $modelPath );
      $modelPath = $modelPath . ".php";

      // Check if the model file exists or not.
      if(!file_exists( $modelPath )) throw new Exception( "Model not found at " . $modelPath );

      // Boot model connections.
      self::bootModel();

      // Import the model file.
      $_class = $modelNamespace . $modelClassName;
      try {
        require_once $modelPath;
        return new $_class();
      } catch( Exception $e ) {
        self::exception( $e );
      }
    }
  }