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
     * Check if a single migration file exists.
     * 
     */
    function isMigrationFileExists( $fileName ) {
      if( file_exists( $this->prepareMigrationFileName( $fileName ) ) ) {
        return true;
      } else {
        return false;
      }
    }

    /**
     * Prepare a single file name.
     */
    function prepareMigrationFileName( $fileName ) {
      $fileName = trim( $fileName );
      $fileName = rtrim( $fileName, '.php' );
      $fileName = ltrim( $fileName, '/' );
      return './app/migrations/' . $fileName . '.php';
    }

    /**
     * Read the migrationlist.json json file and return its value as php array.
     * 
     */
    function readMigrationList() {
      $migrationListFilePath = './app/core/zinc_cli/migration/migrationlist.json';
      // Check if the migration list json document exists or not, if not then create a new one.
      if( ! file_exists( $migrationListFilePath ) ) {
        file_put_contents( $migrationListFilePath, '' );
      }
      $migrationList = file_get_contents( $migrationListFilePath );
      return json_decode( $migrationList, true );
    }

    /**
     * Check if a provided migration has already migrated or not.
     * 
     */
    function ifMigrated( $filePath ) {
      $migrationList = $this->readMigrationList();
      $fileHash      = md5( trim( $filePath ) );
      if( empty( $migrationList ) ) {
        $ifMigrated = false;
        $migrationList = []; // Added an empty array to the migration list as it is empty.
      } else {
        // Check if this file exists in the list.
        if( in_array( $fileHash, $migrationList ) ) {
          $ifMigrated = true;
        } else {
          $ifMigrated = false;
        }
      }
      return $ifMigrated;
    }

    /**
     * This method would add a given migrated file name into the migrationlist.json file.
     * 
     */
    function addAsMigrated( $filePath ) {
      if( ! $this->ifMigrated( $filePath ) ) {
        $migrationList = $this->readMigrationList();
        if( empty( $migrationList ) ) $migrationList = [];
        // Append the new file name to the existing array.
        $migrationList[] = md5( trim( $filePath ) );
        // Save this data to the json file.
        file_put_contents( './app/core/zinc_cli/migration/migrationlist.json', json_encode( $migrationList ) );
      }
    }

    /**
     * Remove from migration list.
     */
    function removeFromMigrationList( $filePath ) {
      $fileHash = md5( trim( $filePath ) );
      $migList  = $this->readMigrationList();
      if( in_array( $fileHash, $migList ) ) {
        unset( $migList[ $fileHash ] );
        // Save updated migration list to the json file.
        file_put_contents( './app/core/zinc_cli/migration/migrationlist.json', json_encode( $migList ) );
      }
    }

    /**
     * Default message when there is nothing to migrate.
     * 
     */
    function noMigratables() {
      echo \OutputCLI\warn( "Nothing to migrate." );
      \OutputCLI\nl();
      exit();
    }

    /**
     * Method to migrate database form the migration file.
     * 
     * @param     string    $migratableFile   The file need to be migrated, 
     *                                        if false then take all migratable files.
     * @return    void
     */
    function migrate ( $migratableFile = false ) {

      // Descide what migration files need to be migrated.
      if ( $migratableFile === false ) {
        // Migrate all new migration files from the migrations directory.
        $migratable = $this->listAllMigrations();
      } else {
        // Migrate a single migration file.
        $migratable = ( array ) $migratableFile;
      }

      // Check if there is any migratables.
      $nothingToMigrate = true; // Setting a flag to detect current status of this migration.
      if ( empty( $migratable ) ) {
        // No new migration file was found.
        $this->noMigratables();
      }

      // Start migrating files.
      foreach ( $migratable as $migratableFile ) {
        // Check if this file is already migrated.
        if ( ! $this->ifMigrated( $migratableFile ) ) {
          print \OutputCLI\warn( "Trying to Migrate:" ) . basename( $migratableFile );
          require_once $migratableFile;
          $className = trim( rtrim( basename( $migratableFile ), '.php' ) );
          $__migrate = new $className( $this );
          $__migrateUp = $__migrate->up();
          if( $__migrateUp === true ) {
            // Add current migration as migrated.
            $this->addAsMigrated( $migratableFile );
            print \OutputCLI\success(" (Success)");
            \OutputCLI\nl();
          } else {
            print \OutputCLI\danger( " (Failed)" );
            \OutputCLI\nl();
            // Check if the error message is a string.
            if ( is_string( $__migrateUp ) ) {
              print '> ' . $__migrateUp;
            } else {
              // We know why this happens
              print \OutputCLI\danger( 'Hint: You may forgot to add the "query()" method in your migration file.' );
            }
            \OutputCLI\nl();
          }
          unset( $__migrate );
          $nothingToMigrate = false;
        }
      }

      // Final check of this migration status.
      if( $nothingToMigrate ) $this->noMigratables();

      // Stop CLI execution.
      exit();

    } // End of 'migrate()' method.

    function runMigrate (  ) {

    }

  }