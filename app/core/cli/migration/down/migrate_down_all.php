<?php
  
  use \ZincPHP\CLI\Helper as CLI;

  require_once './app/core/cli/zincphp_dbm/ZincDBManager.php';
  
  $zincDBManager = new ZincDBManager();
  $migratable = $zincDBManager->listAllMigrations();
  
  if( empty( $migratable ) ) {
    echo CLI\warn( "Nothing to migrate." );
    CLI\nl();
    exit();
  } else {
    $nothingToMigrate = true;
  }

  // Migrate each file.
  foreach( $migratable as $migratableFile ) {
    if( ! $zincDBManager->ifMigrated( $migratableFile ) ) {
      print CLI\warn( "Trying to Migrate:" ) . basename( $migratableFile );
      require_once $migratableFile;
      $className = trim( rtrim( basename( $migratableFile ), '.php' ) );
      $__migrate = new $className( $zincDBManager );
      $__migrate->down();
      unset( $__migrate );
      // Add current migration as migrated.
      $zincDBManager->addAsMigrated( $migratableFile );
      $nothingToMigrate = false;
    }
  }

  if( $nothingToMigrate ) {
    echo CLI\warn( "Nothing to migrate." );
    CLI\nl();
    exit();
  }
  exit(); // End cli execution.
