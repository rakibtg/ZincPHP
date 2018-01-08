<?php
  require_once './app/core/zinc_dbm/ZincDBManager.php';
  
  $zincDBManager = new ZincDBManager();
  $migratable = $zincDBManager->listAllMigrations();
  
  if( empty( $migratable ) ) {
    echo \OutputCLI\warn( "Nothing to migrate." );
    \OutputCLI\nl();
    exit();
  } else {
    $nothingToMigrate = true;
  }

  // Migrate each file.
  foreach( $migratable as $migratableFile ) {
    if( ! $zincDBManager->ifMigrated( $migratableFile ) ) {
      print \OutputCLI\warn( "Trying to Migrate:" ) . basename( $migratableFile );
      require_once $migratableFile;
      $className = trim( rtrim( basename( $migratableFile ), '.php' ) );
      $__migrate = new $className( $zincDBManager );
      $__migrateUp = $__migrate->up();
      // print_r($__migrateUp);
      if( $__migrateUp === true ) {
        // Add current migration as migrated.
        $zincDBManager->addAsMigrated( $migratableFile );
        print \OutputCLI\success(" (Success)");
        \OutputCLI\nl();
      } else {
        print \OutputCLI\danger( " (Failed)" );
        \OutputCLI\nl();
        print '> ' . $__migrateUp;
        \OutputCLI\nl();
      }
      unset( $__migrate );
      $nothingToMigrate = false;
    }
  }

  if( $nothingToMigrate ) {
    echo \OutputCLI\warn( "Nothing to migrate." );
    \OutputCLI\nl();
    exit();
  }
  exit(); // End cli execution.
