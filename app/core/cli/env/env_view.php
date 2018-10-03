<?php

  use \ZincPHP\CLI\Helper as CLI;
  require_once __DIR__ . '/../../environment/ZincEnvironment.php';
  echo CLI\success( 'Environment file details' );
  echo CLI\nl();

  $env = (array) \App::environment();

  if( isset( $env[ 'secret_keys' ] ) ) {
    $env[ 'secret_keys' ] = "hidden";
  }

  echo json_encode( $env, JSON_PRETTY_PRINT );

  echo CLI\nl();
  exit();