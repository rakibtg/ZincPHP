<?php

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
        $seederName = trim( ucfirst( str_replace( ' ', '', $seederName ) ) );
        $seederFile = $this->prepareSeederFileName( $seederName );
        // Check if seeder file already exists.
        if ( ! file_exists( $seederFile ) ) {
          // Create the seeder file to seeders directory.
          $rawSeeder = file_get_contents( './app/core/zinc_structures/new_seed.php.example' );
          // Rename the class.
          $rawSeeder = str_replace( '{{SEED_NAME}}', $seederName, $rawSeeder );
          // Add table name.
          $rawSeeder = str_replace( '{{SEED_TABLE}}', $tableName, $rawSeeder );
          // Save migration file.
          if( file_put_contents( $seederFile, $rawSeeder ) ) {
            print \ZincPHP\CLI\Helper\success( "✔ Seeder file($seederName) was created" );
            \ZincPHP\CLI\Helper\nl();
            print "Migration File Path: " . $seederFile;
            \ZincPHP\CLI\Helper\nl();
          }
        } else {
          // No seeder file name was provided.
          print \ZincPHP\CLI\Helper\danger( '✘ Seeder file already exists!' );
          \ZincPHP\CLI\Helper\nl();
        }
      } else {
        // No seeder file name was provided.
        print \ZincPHP\CLI\Helper\danger( '✘ Please provide a valid seeder name' );
        \ZincPHP\CLI\Helper\nl();
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
        foreach ( $seeders as $seedFile ) {
          if ( file_exists( $seedFile ) ) {
            // Find the class name of the seeder.
            $className = trim( pathinfo( basename( $seedFile ), PATHINFO_FILENAME ) );
            // Instantiate the seeder class.
            require_once $seedFile;
            ( new $className() )->run();
          } else {
            // Seeder file was not found.
            print \ZincPHP\CLI\Helper\warn( '⚠  Seeder file('. basename( $this->prepareSeederFileName( $seedFile ) ) .') was not found' );
            \ZincPHP\CLI\Helper\nl();
          }
        }
      } else {
        // No seeders found.
        print \ZincPHP\CLI\Helper\warn( '⚠  Nothing to seed' );
        \ZincPHP\CLI\Helper\nl();
        print 'To make a seeder, run this: ';
        print \ZincPHP\CLI\Helper\warn( 'php zinc make:seed TableNameSeeder' );
        \ZincPHP\CLI\Helper\nl();
      }
      exit();
    }

  }