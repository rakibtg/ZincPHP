<?php
  require_once './app/core/zinc_dbm/ZincDBManager.php';
  $zincDBManager = new ZincDBManager();
  if( $zincDBManager->isMigrationFileExists( $argv[2] ) ) {
    $migratableFile = $zincDBManager->prepareMigrationFileName( $argv[2] );
    echo \OutputCLI\warn( "Trying to eject the migrate:" ) . basename( $migratableFile );
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
    echo \OutputCLI\danger( 'Migration file was not found' );
    echo \OutputCLI\nl();
    echo \OutputCLI\warn( 'Looking for:' );
    echo $zincDBManager->prepareMigrationFileName( $argv[2] );
    echo \OutputCLI\nl();
  }
  exit();