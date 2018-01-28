<?php

  $_host = '127.0.0.1';   // Default host
  $_port = '8585';        // Default port
  foreach( $argv as $index => $arg ) {
    if( $index > 1 ) {
      if( strtolower( trim( $arg ) ) == '--host' ) $_host = $argv[ $index + 1 ];
      if( strtolower( trim( $arg ) ) == '--port' ) $_port = $argv[ $index + 1 ];
    }
  }
  \ZincPHP\CLI\Helper\nl();
  echo \ZincPHP\CLI\Helper\success( '> ZincPHP development server is running' );
  echo \ZincPHP\CLI\Helper\warn( 'ᕕ(^.^)ᕗ ' );
  \ZincPHP\CLI\Helper\nl();
  \ZincPHP\CLI\Helper\nl();
  echo 'Local Server: http://' . $_host . ':' . $_port;
  \ZincPHP\CLI\Helper\nl();
  chdir( \ZincPHP\CLI\Helper\joinpaths( getcwd(), '/public' ) );
  shell_exec( 'php -S ' . $_host . ':' . $_port );
  exit();