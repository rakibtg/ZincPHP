<?php

  use \ZincPHP\CLI\Helper as CLI;
  require_once './app/core/app/App.php';

  // Check if a env file already exists.
  if( file_exists( './app/environment.json' ) ) {
    echo "environment.json already exists, do you want to overwrite?(Y/n) ";

    $handle = fopen( "php://stdin", "r" );
    $cont   = trim( fgets( $handle ) );

    if( strtolower( $cont ) == 'y' ) {
      echo "Overwriting environment.json file ...";
      CLI\nl();
    } else {
      echo "Action canceled";
      CLI\nl();
      // Exit CLI
      exit();
    }

  }

  // Create the new environment.json file.
  $default_env = json_decode( 
    file_get_contents( './app/core/cli/zincphp_structures/environment.json.example' ) 
  );

  $default_env->secret_keys = App::randomString( 100 );
  file_put_contents( './app/environment.json', json_encode( $default_env, JSON_PRETTY_PRINT ) );
  echo CLI\success( "Environment document has created." );

  CLI\nl();

  // Exit CLI
  exit();
