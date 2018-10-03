<?php

  use \ZincPHP\CLI\Helper as CLI;
  require_once __DIR__ . '/../../environment/ZincEnvironment.php';
  echo CLI\success( '🌧  Environment file details' );
  echo CLI\nl();
  echo CLI\nl();

  $env = (array) \App::environment();

  // Travarse and render each environments.
  function render( $env, $name = false ) {
    foreach ($env as $key => $value) {
      if( is_array( $value ) || is_object( $value ) ) {
        render( $value, $key );
      } else {
        if( $name ) {
          $label = CLI\danger( $name ) . CLI\warn( $key ) . CLI\success( '→' );
        } else {
          $label = CLI\danger( $key ) . CLI\success( '→' );
        }
        echo $label . $value . "\n";
      }
    }
  }

  if( isset( $env[ 'secret_keys' ] ) ) {
    $env[ 'secret_keys' ] = "hidden";
  }

  render( $env );
  // echo json_encode( $env, JSON_PRETTY_PRINT );

  echo CLI\nl();
  exit();