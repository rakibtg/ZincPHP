<?php

  use \ZincPHP\CLI\Helper as CLI;

  /**
   * Methods required for database migration.
   *
   */
  trait MigrationTrait {

    /**
     * List all the migration files.
     * @return    array    List of all PHP file in the migrations directory.
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
     * @param   string    $fileName    Migration file path.
     * @return  boolean   ...          Status of migration file existense.
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
     * Prepare a single file name. Handle the extension of the file name.
     * @param   string    $fileName    Migration file path.
     * @return  string    ...          Proper path of the migration file.
     */
    function prepareMigrationFileName( $fileName ) {
      $fileName = trim( $fileName );
      return './app/migrations/' . trim( pathinfo( basename( $fileName ), PATHINFO_FILENAME ) ) . '.php';
    }

    /**
     * Read the migrationlist.json json file and return its value as php array.
     * @return  array  List of migrated files.
     *
     */
    function readMigrationList() {
      $migrationListFilePath = './app/core/cli/migration/migrationlist.json';
      // Check if the migration list json document exists or not, if not then create a new one.
      if( ! file_exists( $migrationListFilePath ) ) {
        file_put_contents( $migrationListFilePath, '' );
      }
      $migrationList = file_get_contents( $migrationListFilePath );
      return json_decode( $migrationList, true );
    }

    /**
     * Check if a provided migration has already migrated or not.
     * @param   string    $filePath     Migration file path.
     * @return  boolean   ...           The status of migration for the current migration file.
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
     * @param   string    $filePath Migration file path.
     * @return  void      ...       ...
     *
     */
    function addAsMigrated( $filePath ) {
      if( ! $this->ifMigrated( $filePath ) ) {
        $migrationList = $this->readMigrationList();
        if( empty( $migrationList ) ) $migrationList = [];
        // Append the new file name to the existing array.
        $migrationList[] = md5( trim( $filePath ) );
        // Save this data to the json file.
        file_put_contents( './app/core/cli/migration/migrationlist.json', json_encode( $migrationList ) );
      }
    }

    /**
     * Remove from migration list.
     * @param   string    $filePath Migration file path.
     * @return  void      ...       ...
     */
    function removeFromMigrationList( $filePath ) {
      $fileHash = md5( trim( $filePath ) );
      $migList  = $this->readMigrationList();
      if( in_array( $fileHash, $migList ) ) {
        unset( $migList[ array_search( $fileHash, $migList ) ] );
        // Save updated migration list to the json file.
        file_put_contents( './app/core/cli/migration/migrationlist.json', json_encode( $migList ) );
      }
    }

    /**
     * Default message when there is nothing to migrate.
     *
     */
    function noMigratables() {
      echo CLI\warn( "Nothing to migrate." );
      CLI\nl();
      exit();
    }

    /**
     * Method to migrate database form the migration file.
     *
     * @param     string    $migratableFile   The file need to be migrated,
     *                                        if false then take all migratable files.
     * @return    void      ...               ...
     */
    function migrateUp ( $migratableFile = false ) {

      // Descide what migration files need to be migrated.
      if ( $migratableFile === false ) {
        // Migrate all new migration files from the migrations directory.
        $migratable = $this->listAllMigrations();
        $migrateAll = true; // Flag
      } else {
        // Migrate a single migration file.
        $migratable = ( array ) $this->prepareMigrationFileName( $migratableFile );
        $migrateAll = false; // Flag
      }

      // Check if there is any migratables.
      $nothingToMigrate = true; // Setting a flag to detect current status of this migration.
      if ( empty( $migratable ) ) {
        // No new migration file was found.
        $this->noMigratables();
      }

      // Start migrating files.
      foreach ( $migratable as $migratableFile ) {
        // Check if the migration file is still available.
        if ( $this->isMigrationFileExists( $migratableFile ) ) {
          // Check if this file is already migrated.
          if ( ! $this->ifMigrated( $migratableFile ) ) {
            // Run migrate
            $this->runMigrateUp( $migratableFile );
            // Change the migrations flag status to false, meaning that we migrated one or more than
            // one migration file.
            $nothingToMigrate = false;
          } else {
            // Check if this was a single migration, then show an error.
            // Also ask the user if he/she want to call the down() then up() to force migrate.
            if ( $migrateAll === false ) {
              print CLI\danger( "Error: Migration file " . basename( $migratableFile ) . " already migrated." );
              CLI\nl();
              print CLI\warn( "Hint: Delete the table/column manually." );
              CLI\nl();
              // Ask the user if he want to execute the query.
              print "Do you want to force migrate? (y/n) ";
              $handle = fopen( "php://stdin", "r" );
              $cont   = trim( fgets( $handle ) );
              if( strtolower( $cont ) === 'y' ) {
                echo CLI\warn( "Force migrating:" ) . basename( $migratableFile );
                CLI\nl();
                // Run the migration again.
                $this->runMigrateUp( $migratableFile );
              } else {
                echo 'Force migration canceled.';
                CLI\nl();
              }
            }
          }
        } else {
          print CLI\danger( "Error: Migration file " . basename( $migratableFile ) . " file was not found." );
          CLI\nl();
        }
      }

      // Final check of this migration status.
      if( $nothingToMigrate ) $this->noMigratables();

    } // End of migrateUp() method.

    /**
     * Method to migrate the migration file.
     *
     * @param     string    $migratableFile   The file need to be migrated
     * @return    void      ...               ...
     */

    function runMigrateUp ( $migratableFile ) {
      // Current migration file of this iteration is new, try to migrate it.
      print CLI\warn( "Trying to Migrate:" ) . basename( $migratableFile );
      // Add the migration file runtime.
      require_once $migratableFile;
      try {
        // Get the class name for this migration file.
        $className = trim( pathinfo( basename( $migratableFile ), PATHINFO_FILENAME ) );
        // Call the class with the dynamically generated name.
        // Also, pass the current db manager object, so in the migration class we can use all the methods.
        $__migrate = new $className( $this );
        // Do migrate.
        $__migrateUp  = $__migrate->up( \App::schema() );
        // Migration was successful, adding current migration as migrated.
        $this->addAsMigrated( $migratableFile );
        // Display success message.
        print CLI\success(" (✔ Success)");
        CLI\nl();
      } catch ( Exception $e ) {
        print CLI\danger( " (✘ Failed)" );
        CLI\nl();
        CLI\nl();
        print CLI\danger( "Error Message:" );
        echo $e->getMessage();
        CLI\nl();
        CLI\nl();
      }

    } // End of runMigrateUp() method.

    // Migrate down a migration.
    function migrateDown( $migratableFile = false ) {
      // Descide which migration file needed to be ejected.
      if ( $migratableFile === false ) {
        // Eject all existing migrations.
        $migratable = $this->listAllMigrations();
        $migrateAll = true; // Flag
      } else {
        $migratable = ( array ) $this->prepareMigrationFileName( $migratableFile );
        $migrateAll = false; // Flag
      }

      // Check if there is any migratables that are ejectable.
      $nothingToMigrate = true;
      if ( empty( $migratable) ) {
        echo CLI\warn( "No migrate to eject." );
        CLI\nl();
        exit();
      }

      // Start ejecting migrations.
      foreach ( $migratable as $migratableFile ) {
        if ( $this->isMigrationFileExists( $migratableFile ) ) {
          if ( $this->ifMigrated( $migratableFile ) ) {
            // File migrated.
            $this->runMigrateDown( $migratableFile );
            $nothingToMigrate = false;
          } else {
            // File was not migrated.
            print CLI\danger( "Error: " . basename( $migratableFile ) . " not migrated yet." );
            CLI\nl();
          }
        } else {
          print CLI\danger( "Error: Migration file " . basename( $migratableFile ) . " file was not found." );
          CLI\nl();
        }
      }

    } // End of migrateDown() method.

    function runMigrateDown( $migratableFile ) {
      echo CLI\warn( 'Trying to eject: ' ) . basename( $migratableFile );
      // Import the migration file.
      require_once $migratableFile;
      // Get the class name for the migration file.
      $className = trim( pathinfo( basename( $migratableFile ), PATHINFO_FILENAME ) );
      // Call the class with the dynamically generated name.
      // Also, pass the current db manager object, so in the migration class we can use all the methods.
      $__migrate = new $className( $this );
      // Run the down method.
      try {
        $__migrateDown  = $__migrate->down( \App::schema() );
        $this->removeFromMigrationList( $migratableFile );
        print CLI\success(" (✔ Success)");
        CLI\nl();
      } catch ( \Error $e ) {
        print CLI\danger(" (✘ Failed)");
        CLI\nl();
        print CLI\danger( "✘ " . $e->getMessage() );
        CLI\nl();
      }
    }

  }
