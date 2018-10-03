<?php

  use \ZincPHP\CLI\Helper as CLI;

  $envFile = \App::dir( 'app/environment.json' );
  if( file_exists( $envFile ) ) {
    echo CLI\success( 'Environment file details' );
    echo CLI\nl();
    print_r( \App::environment() );
  }

  exit();