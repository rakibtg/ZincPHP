<?php

  /**
   * Methods required for database migration.
   *
   */
  trait MigrationTrait {

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

  }
