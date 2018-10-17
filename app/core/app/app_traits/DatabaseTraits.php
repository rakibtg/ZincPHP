<?php
  trait DatabaseTraits {

    /**
     * Importing a database table model in your code.
     * 
     */
    public static function model( $modelPath = '' ) {
      if(empty($modelPath)) throw new Exception("Model name can't be empty");

      $modelPath = trim((string) $modelPath);

      // Generate the absolute path of the model file.
      if($modelPath[0] !== "/") $modelPath = \App::dir("models") . '/' . $modelPath;
      else $modelPath = \App::dir("models") . $modelPath;

      $modelClassName = basename($modelPath);
      $modelPath = $modelPath . ".php";

      // Check if the model file exists or not.
      if(!file_exists($modelPath)) throw new Exception("Model not found at " . $modelPath);

      // Boot model connections.
      \App::bootModel();

      // Import the model file.
      require_once $modelPath;
      return new $modelClassName();

      return [
        "path" => $modelPath,
        "file" => $modelClassName
      ];
    }


  }