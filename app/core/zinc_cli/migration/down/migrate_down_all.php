<?php
  require_once './app/core/zinc_cli/zincphp_dbm/ZincDBManager.php';
  
  $zincDBManager = new ZincDBManager();
  $migratable = $zincDBManager->listAllMigrations();
  
  if( empty( $migratable ) ) {
    echo \ZincPHP\CLI\Helper\warn( "Nothing to migrate." );
    \ZincPHP\CLI\Helper\nl();
    exit();
  } else {
    $nothingToMigrate = true;
  }

  // Migrate each file.
  foreach( $migratable as $migratableFile ) {
    if( ! $zincDBManager->ifMigrated( $migratableFile ) ) {
      print \ZincPHP\CLI\Helper\warn( "Trying to Migrate:" ) . basename( $migratableFile );
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
    echo \ZincPHP\CLI\Helper\warn( "Nothing to migrate." );
    \ZincPHP\CLI\Helper\nl();
    exit();
  }
  exit(); // End cli execution.
