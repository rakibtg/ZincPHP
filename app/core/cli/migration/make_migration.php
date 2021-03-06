<?php

  use \ZincPHP\CLI\Helper as CLI;

  /**
   * Creates a new migration file.
   */

  // Validate the migration file name.
  if( ! isset( $argv[ 2 ] ) ) exit( CLI\danger( "No migration name found\n" ) );
  if( empty( $argv[ 2 ] ) ) exit( CLI\warn( "Migration name cant be empty\n" ) );
 
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
        echo CLI\danger( "> Ops! Table name is not valid and can not be empty");
        echo CLI\nl();
        echo CLI\warn( "Hint: Use the argument '--table' properly. E.g: --table=users");
        echo CLI\nl();
        exit();
      }
    }
  }
  
  // Process migration name.
  if ( $tableName === false ) {
    // Table name was not provided using the system argument --table
    $tableName = strtolower( trim( $argv[ 2 ] ) );
  }

  // Generate and format the migration file name.
  $migrationName = trim( $argv[ 2 ] );
  $migrationName = ucfirst( str_replace( '-', ' ', $migrationName ) );
  $migrationName = ucfirst( str_replace( '_', ' ', $migrationName ) );
  $migrationName = explode( ' ', $migrationName );
  foreach( $migrationName as $key => $mn ) {
    $migrationName[ $key ] = trim( ucfirst( $mn ) );
  }
  $migrationName = implode( $migrationName );
  $migrationFileName = \App::dir('migrations/' . $migrationName . '.php');
  // If the migration folder doesn't exists then create it.
  if( ! file_exists( \App::dir('migrations') ) ) {
    mkdir( \App::dir('migrations') );
  }
  if( ! file_exists( $migrationFileName ) ) {
    // Copy new migration template to migrations directory.
    $rawMigratable = file_get_contents( __DIR__ . '/../zincphp_structures/new_migration.php.example' );
    // Rename the class.
    $rawMigratable = str_replace( '{{Migration}}', $migrationName, $rawMigratable );
    // Add table name.
    $rawMigratable = str_replace( '{{MigrationRawName}}', $tableName, $rawMigratable );
    // Save migration file.
    if( file_put_contents( $migrationFileName, $rawMigratable ) ) {
      print CLI\success( "✔ Migration file($migrationName) was created" );
      CLI\nl();
      print "Migration File Path: " . $migrationFileName;
      CLI\nl();
    }
  } else {
    print CLI\danger( "Error: Migration file($migrationName) already exists!\n" ) 
     . "Migration File Path: " 
     . $migrationFileName 
     . "\n";
  }
  exit(); // End of the zinc cli execution
