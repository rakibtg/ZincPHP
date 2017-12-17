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
      $__migrate->up();
      unset( $__migrate );
      // Add current migration as migrated.
      $zincDBManager->addAsMigrated( $migratableFile );
      $nothingToMigrate = false;
    }
  }

  if( $nothingToMigrate ) {
    echo \OutputCLI\warn( "Nothing to migrate." );
    \OutputCLI\nl();
    exit();
  }
  exit(); // End cli execution.
