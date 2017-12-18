<?php

  /**
   * Creates a new migration file.
   */

  if( ! isset( $argv[ 2 ] ) ) exit( \OutputCLI\danger( "No migration name found\n" ) );
  if( empty( $argv[ 2 ] ) ) exit( \OutputCLI\warn( "Migration name cant be empty\n" ) );

  // Process migration name.
  $tableName     = trim( $argv[ 2 ] );
  $migrationName = strtolower( $tableName );
  $migrationName = ucfirst( str_replace( '-', ' ', $migrationName ) );
  $migrationName = ucfirst( str_replace( '_', ' ', $migrationName ) );
  $migrationName = explode( ' ', $migrationName );
  foreach( $migrationName as $key => $mn ) {
    $migrationName[ $key ] = trim( ucfirst( $mn ) );
  }
  $migrationName = implode( $migrationName );
  $migrationFileName = \OutputCLI\joinpaths( getcwd(), 'app/migrations', $tableName . '.php' );
  // If the migration folder dosent exists then create it.
  if( ! file_exists( 'app/migrations' ) ) {
    mkdir( 'app/migrations' );
  }
  if( ! file_exists( $migrationFileName ) ) {
    // Copy new migration template to migrations directory.
    $rawMigratable = file_get_contents( './app/core/zinc_structures/new_migration.php.example' );
    // Rename the class.
    $rawMigratable = str_replace( '{{Migration}}', $migrationName, $rawMigratable );
    // Add table name.
    $rawMigratable = str_replace( '{{MigrationRawName}}', $tableName, $rawMigratable );
    // Save migration file.
    if( file_put_contents( $migrationFileName, $rawMigratable ) ) {
      print \OutputCLI\success( "Migration file($migrationName) was created" );
      \OutputCLI\nl();
      print "Migration File Path: " . $migrationFileName;
      \OutputCLI\nl();
    }
  } else {
    print \OutputCLI\danger( "Error: Migration file($migrationName) already exists!\n" ) . "Migration File Path: " . $migrationFileName . "\n";
  }
  exit(); // End of the zinc cli execution
