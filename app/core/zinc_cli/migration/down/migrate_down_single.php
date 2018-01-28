<?php
  require_once './app/core/zinc_dbm/ZincDBManager.php';
  $zincDBManager = new ZincDBManager();
  if( $zincDBManager->isMigrationFileExists( $argv[2] ) ) {
    $migratableFile = $zincDBManager->prepareMigrationFileName( $argv[2] );
    echo \ZincPHP\CLI\Helper\warn( "Trying to eject the migrate:" ) . basename( $migratableFile );
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
    echo \ZincPHP\CLI\Helper\danger( 'Migration file was not found' );
    echo \ZincPHP\CLI\Helper\nl();
    echo \ZincPHP\CLI\Helper\warn( 'Looking for:' );
    echo $zincDBManager->prepareMigrationFileName( $argv[2] );
    echo \ZincPHP\CLI\Helper\nl();
  }
  exit();