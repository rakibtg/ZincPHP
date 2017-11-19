<?php

  /**
   * Methods required for database migration.
   *
   */
  trait MigrationTrait {

    function listAllMigrations() {
      $migratableFiles = scandir( './inc/migrations' );
      $toMigrate = [];
      foreach( $migratableFiles as $mf ) {
        if( $mf != '.' && $mf != '..' && substr( trim( $mf ), -4 ) == '.php' ) {
          $toMigrate[] = './inc/migrations/' . $mf;
        }
      }
      return $toMigrate;
    }

  }
