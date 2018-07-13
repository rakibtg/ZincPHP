<?php
  namespace ZincPHP\CLI\Helper;

  /**
   * Get argument variables with value as an associative array.
   *
   * @param   array System argument variables.
   * @return  array
   */
  function getArgumentVariables( $arg = [] ) {
    $arguments = [];
    foreach ( $arg as $a ) {
      if ( ( strpos( $a, '--') !== false ) && ( strpos( $a, '=' ) !== false ) ) {
        $_a = explode( '=', ltrim( $a, '--' ) );
        $arguments[ trim( $_a[ 0 ] ) ] = trim( $_a[ 1 ] );
      }
    }
    return $arguments;
  }

  /**
   * Outputs danger.
   */
  function danger( $msg ) {
    if( PHP_OS != 'WINNT'  ) {
      return "\033[31m$msg \033[0m";
    } else {
      return $msg;
    }
  }

  /**
   * Output success.
   */
  function success( $msg ) {
    if( PHP_OS != 'WINNT'  ) {
      return "\033[32m$msg \033[0m";
    } else {
      return $msg;
    }
  }

  /**
   * Output warning.
   */
  function warn( $msg ) {
    if( PHP_OS != 'WINNT'  ) {
      return "\033[33m$msg \033[0m";
    } else {
      return $msg;
    }
  }

  /**
   * New line; Helpful for those who using ZSH.
   */
  function nl() {
    echo "\n";
  }

  /**
   * Generate a safe file name for blocks, migrations, seeders and libraries.
   * If user typed a .php extention with a block name, then it would remove that (.php)
   * extension to be used as a block name. Later the extension would be added as requires.
   * 
   */
  function safeFileName( $fileName = '' ) {
    $_fn = trim( $fileName );
    if ( empty( $_fn ) ) return $_fn;
    // Get the basename.
    $_fn = basename( $_fn );
    // If the .php extension is with the name, then remove it.
    if ( substr( trim( $_fn ), -4 ) == '.php' ) {
      return substr( $_fn, 0, -4 );
    }
    return $_fn;
  }

  function trimds( $s ) {
    return rtrim( $s, DIRECTORY_SEPARATOR );
  }

  function joinpaths() {
    return implode( DIRECTORY_SEPARATOR, array_map( '\ZincPHP\CLI\Helper\trimds', func_get_args() ) );
  }
