<?php

  trait SeedsTrait {

    /**
     * Get a list of all seeds files, sort by ASC.
     * 
     */
    function listAllSeeds() {
      //
    }

    /**
     * Make a seed file.
     * 
     */
    function makeSeed( $seederName = '' ) {
      if ( ! empty( $seederName ) ) {

      } else {
        // No seeder file name was provided.
      }
    }

    /**
     * Returns number of total seeders created.
     * This count number will be helpful to order seeder files.
     * 
     * @return  integer  Total number of seeders created.
     */
    function seedsCount() {
      $countPath = './app/core/zinc_cli/seed/seed_count.db';
      if ( ! file_exists( $countPath ) ) {
        file_put_contents( $countPath, '0' );
      }
      return ( int ) file_get_contents( './app/core/zinc_cli/seed/seed_count.db' ); 
    }


    function seed() {
      //
    }

  }