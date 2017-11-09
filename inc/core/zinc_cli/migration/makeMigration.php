<?php

  /**
   * Creates a new migration file.
   *
   */

  if( ! isset( $argv[ 2 ] ) ) exit( "No migration name was found\n" );
  if( empty( $argv[ 2 ] ) ) exit( "Migration name cant be empty\n" );

  $migrationName = trim( strtolower( $argv[ 2 ] ) );
  $migrationName = str_replace( ' ', '_', $migrationName );
  $migrationName = joinpaths( getcwd(), 'inc/migrations', $migrationName . '.php' );
  if( ! file_exists( $migrationName ) ) {
    // Copy new migration template to migrations directory.
    if( copy( './inc/core/structures/new_migration.php.example', $migrationName ) ) {
      print "Migration file($migrationName) was created\n";
    }
  } else {
    print "Error: Migration file($migrationName) already exists!\n";
  }
  exit(); // End of the zinc cli execution