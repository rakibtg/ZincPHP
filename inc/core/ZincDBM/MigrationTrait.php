<?php

  /**
   * Methods required for database migration.
   * 
   */
  trait MigrationTrait {

    function listAllMigrations() {
      $migratableFiles = scandir( './inc/migrations' );
      \zp\pr($migratableFiles);
      return $this;
    }

  }
