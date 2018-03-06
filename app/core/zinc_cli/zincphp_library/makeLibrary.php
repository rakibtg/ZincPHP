<?php

  // print_r( $argv );

  /**
   * Get all argument values as an assosiative array.
   *
   * @var array   $arguments
   */
  $arguments = \ZincPHP\CLI\Helper\getArgumentVariables( $argv );

  /**
   * Cache the library directory path.
   *
   * @var string  $libraryPath
   */
  $libraryPath = App::dir( 'libraries' );

  /**
   * Library name.
   *
   * @var string  $libraryName
   */
  $libraryName = App::strTrim( $argv[ 2 ] );

  /*
    Validate the library name.
  */

  // Checking for empty.
  if ( empty( $libraryName ) ) {
    echo \ZincPHP\CLI\Helper\danger( "> Error: Library name is not valid." );
    \ZincPHP\CLI\Helper\nl();
    exit();
  }

  // checking for whitespaces
  if ( preg_match( '/\s/', $libraryName ) ) {
    echo \ZincPHP\CLI\Helper\danger( "> Error: Library name should not have any whitespaces." );
    \ZincPHP\CLI\Helper\nl();
    exit();
  }

  /**
   * Library file name with extension.
   *
   * @var string  $libraryFileName
   */
  $libraryFileName = trim( pathinfo( basename( $libraryName ), PATHINFO_FILENAME ) ) . '.php';

  /**
   * Library file path.
   *
   * @var string  $libraryFilePath
   */
  $libraryFilePath = $libraryPath . '/' . $libraryName . '/' . $libraryFileName;

  // Check if there is already a library.
  if ( file_exists( $libraryFilePath ) ) {
    echo \ZincPHP\CLI\Helper\danger( "> Error: Library file already exists." );
    \ZincPHP\CLI\Helper\nl();
    exit();
  }

  /**
   * Library type; if it should contain a function or a class.
   *
   * @var string  $libraryType
   */
  $libraryType = 'function';
  if ( isset( $arguments[ 'type' ] ) ) {
    if ( $arguments[ 'type' ] === 'class' ) $libraryType = 'class';
  }

  /*
    - Create all directories.
    - get the template based on library type.
    - replace values.
    - save the library.
  */


  exit();
