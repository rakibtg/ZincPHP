<?php

  use \ZincPHP\CLI\Helper as CLI;

  $_host = '127.0.0.1';   // Default host
  $_port = '8585';        // Default port
  foreach( $argv as $index => $arg ) {
    if( $index > 1 ) {
      if( strtolower( trim( $arg ) ) == '--host' ) $_host = $argv[ $index + 1 ];
      if( strtolower( trim( $arg ) ) == '--port' ) $_port = $argv[ $index + 1 ];
    }
  }

  echo CLI\success( '> ZincPHP development server is running' );
  if ( PHP_OS != 'WINNT' ) {
    echo CLI\warn( ' ᕕ(^.^)ᕗ ' );
  } else {
    echo CLI\warn( ' (^.^) ' );
  }
  
  CLI\nl();
  CLI\nl();
  echo 'Local Server: http://' . $_host . ':' . $_port;
  CLI\nl();
  chdir( CLI\joinpaths( getcwd(), '/public' ) );
  shell_exec( 'php -S ' . $_host . ':' . $_port );
  exit();