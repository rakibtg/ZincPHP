<?php

  /**
   * Methods required for database migration.
   *
   */
  trait MigrationTrait {

    /**
     * List all the migration files.
     * 
     */
    function listAllMigrations() {
      $migratableFiles = scandir( './app/migrations' );
      $toMigrate = [];
      foreach( $migratableFiles as $mf ) {
        if( $mf != '.' && $mf != '..' && substr( trim( $mf ), -4 ) == '.php' ) {
          $toMigrate[] = './app/migrations/' . $mf;
        }
      }
      return $toMigrate;
    }

    /**
     * Read the migrationlist.json json file and return its value as php array.
     * 
     */
    function readMigrationList() {
      $migrationList = file_get_contents( './app/core/zinc_cli/migration/migrationlist.json' );
      return json_decode( $migrationList, true );
    }

    /**
     * This method would add a given migrated file name into the migrationlist.json file.
     * 
     */
    function addAsMigrated( $filePath ) {
      $migrationList = $this->readMigrationList();
      $fileHash      = md5( trim( $filePath ) );
      if( empty( $migrationList ) ) {
        $migratable = true;
        $migrationList = []; // Added an empty array to the migration list as it is empty.
      } else {
        $migratable = false;
        // Check if this file exists in the list.
        if( ! in_array( $fileHash, $migrationList ) ) {
          $migratable = true;
        } else {
          $migratable = false;
        }
      }
      if( $migratable == true ) {
        // Append the new file name to the existing array.
        $migrationList[] = $fileHash;
        // Save this data to the json file.
        file_put_contents( './app/core/zinc_cli/migration/migrationlist.json', json_encode( $migrationList ) );
      }
      return $migratable;
    }

  }
