<?php

  require_once './app/core/app_getter/App.php';

  // Check if a env file already exists.
  if( file_exists( './app/environment.json' ) ) {
    echo "environment.json already exists, do you want to overwrite?(Y/n) ";
    $handle = fopen( "php://stdin", "r" );
    $cont   = trim( fgets( $handle ) );
    if( strtolower( $cont ) == 'y' ) {
      echo "Overwriting environment.json file ...";
      \ZincPHP\CLI\Helper\nl();
    } else {
      echo "Action canceled";
      \ZincPHP\CLI\Helper\nl();
      exit();
    }
  }
  // Create the new environment.json file.
  $default_env = json_decode( file_get_contents( './app/core/cli/zincphp_structures/environment.json.example' ) );
  $default_env->secret_keys = bin2hex( App::randomString( 64 ) );
  file_put_contents( './app/environment.json', json_encode( $default_env, JSON_PRETTY_PRINT ) );
  echo \ZincPHP\CLI\Helper\success( "Environment document has created." );
  \ZincPHP\CLI\Helper\nl();
  exit();
