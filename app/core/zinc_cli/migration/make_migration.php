<?php

  /**
   * Creates a new migration file.
   */

  // Validate the migration file name.
  if( ! isset( $argv[ 2 ] ) ) exit( \OutputCLI\danger( "No migration name found\n" ) );
  if( empty( $argv[ 2 ] ) ) exit( \OutputCLI\warn( "Migration name cant be empty\n" ) );
 
  // table name flag, false means that later we need to give it a name.
  $tableName = false;

  if( isset( $argv[ 3 ] ) ) {

    // Prepare argument, split it by '=' default.
    $argv3 = explode( '=', $argv[ 3 ] );
    // Checking if --table argument was provided.
    if( $argv3[ 0 ] == '--table' ) {
      // Checking if the table name for this migration was provided in the system argument.
      if( isset( $argv3[ 1 ] ) && ! empty( $argv3[ 1 ] ) ) {
        $tableName = $argv3[ 1 ];
      }
      // Check if the provided table name for this migration was invalid.
      if( $tableName === false ) {
        echo \OutputCLI\danger( "> Ops! Table name is not valid and can not be empty");
        echo \OutputCLI\nl();
        echo \OutputCLI\warn( "Hint: Use the argument '--table' properly. E.g: --table=users");
        echo \OutputCLI\nl();
        exit();
      }
    }
  }
  
  // Process migration name.
  if ( $tableName === false ) {
    // Table name was not provided using the system argument --table
    $tableName = trim( $argv[ 2 ] );
  }

  // Generate and formet the migration file name.
  $migrationName = strtolower( trim( $argv[ 2 ] ) );
  $migrationName = ucfirst( str_replace( '-', ' ', $migrationName ) );
  $migrationName = ucfirst( str_replace( '_', ' ', $migrationName ) );
  $migrationName = explode( ' ', $migrationName );
  foreach( $migrationName as $key => $mn ) {
    $migrationName[ $key ] = trim( ucfirst( $mn ) );
  }
  $migrationName = implode( $migrationName );
  $migrationFileName = \OutputCLI\joinpaths( getcwd(), 'app/migrations', $migrationName . '.php' );
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
