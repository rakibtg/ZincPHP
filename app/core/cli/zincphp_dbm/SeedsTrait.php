<?php

  use \ZincPHP\CLI\Helper as CLI;

  trait SeedsTrait {

    /**
     * Get a list of all seeds files, sort by created at ASC.
     * 
     * @return  array  List of seeder files.
     */
    function listAllSeeds() {
      $files = glob( './app/seeders/*.php' );
      usort( $files, function ( $a, $b ) {
        return filemtime($a) > filemtime($b);
      } );
      return $files;
    }

    /**
     * Prepare a single seeder file name.
     * @param   string    $fileName    Migration file path.
     * @return  string    ...          Proper path of the migration file.
     */
    function prepareSeederFileName( $fileName ) {
      return './app/seeders/' . trim( pathinfo( basename( $fileName ), PATHINFO_FILENAME ) ) . '.php';
    }

    /**
     * Make a seed file.
     * 
     */
    function makeSeed( $seederName = '', $tableName = '' ) {
      if ( ! empty( $seederName ) ) {
        // Check if seeders directory exists in the app directory.
        if ( ! file_exists( './app/seeders' ) ) {
          // Create the seeders directory.
          if ( ! mkdir( './app/seeders' ) ) {
            // No seeder file name was provided.
            print CLI\danger( '✘ Unable to create the seeders directory.' );
            CLI\nl();
            echo 'Please check if PHP has write permission, try to create the seeders directory at "./app/seeders"';
            CLI\nl();
            exit();
          }
        }
        $seederName = trim( ucfirst( str_replace( ' ', '', $seederName ) ) );
        $seederFile = $this->prepareSeederFileName( $seederName );
        // Check if seeder file already exists.
        if ( ! file_exists( $seederFile ) ) {
          // Create the seeder file to seeders directory.
          $rawSeeder = file_get_contents( './app/core/cli/zincphp_structures/new_seed.php.example' );
          // Rename the class.
          $rawSeeder = str_replace( '{{SEED_NAME}}', $seederName, $rawSeeder );
          // Add table name.
          $rawSeeder = str_replace( '{{SEED_TABLE}}', $tableName, $rawSeeder );
          // Save migration file.
          if( file_put_contents( $seederFile, $rawSeeder ) ) {
            print CLI\success( "✔ Seeder file($seederName) was created" );
            CLI\nl();
            print "Migration File Path: " . $seederFile;
            CLI\nl();
          }
        } else {
          // No seeder file name was provided.
          print CLI\danger( '✘ Seeder file already exists!' );
          CLI\nl();
        }
      } else {
        // No seeder file name was provided.
        print CLI\danger( '✘ Please provide a valid seeder name' );
        CLI\nl();
      }
    }

    function seed( $argv ) {
      
      // Check if we should seed all or seed a single seeder.
      if ( isset( $argv[ 2 ] ) ) {
        // Prepare seeder file path.
        $seeders = ( array ) $this->prepareSeederFileName( $argv[ 2 ] );
      } else {
        $seeders = $this->listAllSeeds();
      }

      // Check if we have seeders to seed.
      if ( ! empty( $seeders ) ) {
        // Creating a new instance of the query builder.
        foreach ( $seeders as $seedFile ) {
          if ( file_exists( $seedFile ) ) {
            // Find the class name of the seeder.
            $className = trim( pathinfo( basename( $seedFile ), PATHINFO_FILENAME ) );
            print CLI\warn( "Trying to seed:" );
            print $className;
            try {
              require_once $seedFile;
              print CLI\success( ' (✔ Success)' );
              CLI\nl();
            } catch( Exception $e ) {
              print CLI\danger( ' (✘ Failed)' );
              CLI\nl();
              print CLI\danger( "Error Message: " );
              echo $e->getMessage();
              CLI\nl();
              CLI\nl();
            }
          } else {
            // Seeder file was not found.
            print CLI\warn( '❗ Seeder file('. basename( $this->prepareSeederFileName( $seedFile ) ) .') was not found' );
            CLI\nl();
          }
        }
      } else {
        // No seeders found.
        print CLI\warn( '❗ Nothing to seed' );
        CLI\nl();
        print 'To make a seeder, run this: ';
        print CLI\warn( 'php zinc make:seed TableNameSeeder' );
        CLI\nl();
      }
      exit();
    }

  }