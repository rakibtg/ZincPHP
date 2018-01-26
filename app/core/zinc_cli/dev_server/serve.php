<?php

  $_host = '127.0.0.1';   // Default host
  $_port = '8585';        // Default port
  foreach( $argv as $index => $arg ) {
    if( $index > 1 ) {
      if( strtolower( trim( $arg ) ) == '--host' ) $_host = $argv[ $index + 1 ];
      if( strtolower( trim( $arg ) ) == '--port' ) $_port = $argv[ $index + 1 ];
    }
  }
  \OutputCLI\nl();
  echo \OutputCLI\success( '> ZincPHP development server is running' );
  echo \OutputCLI\warn( 'ᕕ(^.^)ᕗ ' );
  \OutputCLI\nl();
  \OutputCLI\nl();
  echo 'Local Server: http://' . $_host . ':' . $_port;
  \OutputCLI\nl();
  chdir( \OutputCLI\joinpaths( getcwd(), '/public' ) );
  shell_exec( 'php -S ' . $_host . ':' . $_port );
  exit();