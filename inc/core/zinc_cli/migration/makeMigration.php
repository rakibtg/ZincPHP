<?php

  /**
   * Creates a new migration file.
   */

  if( ! isset( $argv[ 2 ] ) ) exit( \OuputCLI\danger( "No migration name found\n" ) );
  if( empty( $argv[ 2 ] ) ) exit( \OuputCLI\warn( "Migration name cant be empty\n" ) );

  // Process migration name.
  $migrationName = trim( strtolower( $argv[ 2 ] ) );
  $migrationName = ucfirst( str_replace( '-', ' ', $migrationName ) );
  $migrationName = ucfirst( str_replace( '_', ' ', $migrationName ) );
  $migrationName = explode( ' ', $migrationName );
  foreach( $migrationName as $key => $mn ) {
    $migrationName[ $key ] = trim( ucfirst( $mn ) );
  }
  $migrationName = implode( $migrationName );
  $migrationFileName = joinpaths( getcwd(), 'inc/migrations', $migrationName . '.php' );
  if( ! file_exists( $migrationFileName ) ) {
    // Copy new migration template to migrations directory.
    $rawMigratable = file_get_contents( './inc/core/structures/new_migration.php.example' );
    // Rename the class.
    $rawMigratable = str_replace( '{{Migration}}', $migrationName, $rawMigratable );
    // Save migration file.
    if( file_put_contents( $migrationFileName, $rawMigratable ) ) {
      print \OuputCLI\success( "Migration file($migrationName) was created\n" ) . "Migration File Path: " . $migrationFileName . "\n";
    }
    // if( copy( './inc/core/structures/new_migration.php.example', $migrationName ) ) {
    //   print \OuputCLI\success( "Migration file($migrationName) was created\n" );
    // }
  } else {
    print \OuputCLI\danger( "Error: Migration file($migrationName) already exists!\n" ) . "Migration File Path: " . $migrationFileName . "\n";
  }
  exit(); // End of the zinc cli execution
