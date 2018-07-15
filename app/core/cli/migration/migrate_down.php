<?php

  require_once './app/core/cli/zincphp_dbm/ZincDBManager.php';

  // Check do we need to migrate a single file or all available migrations.
  if ( isset( $argv[ 2 ] ) ) {
    // Migrate a single file.
    ( new ZincDBManager() )->migrateDown( $argv[ 2 ] );
  } else {
    // Migrate all new migration files that are not migrated yet.
    ( new ZincDBManager() )->migrateDown();
  }

  exit();