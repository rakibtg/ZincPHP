<?php

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

  // Validate the library name.

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
    echo \ZincPHP\CLI\Helper\danger( "> Library file already exists." );
    \ZincPHP\CLI\Helper\nl();
    exit();
  }

  // Create directories of the library.
  if( ! file_exists( $libraryPath . '/' . $libraryName . '/' ) ) {
    mkdir( $libraryPath . '/' . $libraryName . '/', 0777, true );
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

  /**
   * Library namespace.
   * Default will be the library path from the libraries directory.
   * 
   * @var string  $libraryNamespace
   */
  if ( ! isset( $arguments[ 'namespace' ] ) ) $arguments[ 'namespace' ] = '';
  if ( ! empty( App::strTrim( $arguments[ 'namespace' ] ) ) ) {
    // Use the custom namespace.
    $libraryNamespace = App::strTrim( $arguments[ 'namespace' ] );
  } else {
    // Use the default namespace.
    $libraryNamespace = str_replace( '/', '\\', $libraryName );
  }

  // Getting the template based on library type.
  if ( $libraryType === 'class' ) $template = file_get_contents( __DIR__ . '/template/classLib.example.php' );
  else $template = file_get_contents( __DIR__ . '/template/functionLib.example.php' );

  // Update the values of the template.
  $template = str_replace( '{NameSpaceName}', $libraryNamespace, $template );
  $template = str_replace( '{LibraryName}', trim( pathinfo( basename( $libraryName ), PATHINFO_FILENAME ) ), $template );
  
  // Save the library.
  file_put_contents( $libraryFilePath, $template );

  // Success.
  echo \ZincPHP\CLI\Helper\success( "> Library created successfully." );
  \ZincPHP\CLI\Helper\nl();
  echo "Path: " . $libraryFilePath;
  \ZincPHP\CLI\Helper\nl();

  // Release the CLI
  exit();
