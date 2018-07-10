<?php
  
  use \ZincPHP\CLI\Helper as CLI;
  require_once './app/core/cli/zincphp_dbm/ZincDBManager.php';

  $zincDBManager = new ZincDBManager();
  if( $zincDBManager->isMigrationFileExists( $argv[2] ) ) {
    $migratableFile = $zincDBManager->prepareMigrationFileName( $argv[2] );

    echo CLI\warn( "Trying to eject the migrate:" ) 
     . basename( $migratableFile );
     
    // Check if the file was already migrated or not.
    if( ! $zincDBManager->ifMigrated( $migratableFile ) ) {
      require_once $migratableFile;
      $className = trim( rtrim( basename( $migratableFile ), '.php' ) );
      $__migrate = new $className( $zincDBManager );
      $__migrate->down();
      unset( $__migrate );
      // Add current migration as migrated.
      $zincDBManager->addAsMigrated( $migratableFile );
    }
  } else {
    echo CLI\danger( 'Migration file was not found' );
    echo CLI\nl();
    echo CLI\warn( 'Looking for:' );
    echo $zincDBManager->prepareMigrationFileName( $argv[2] );
    echo CLI\nl();
  }
  exit();