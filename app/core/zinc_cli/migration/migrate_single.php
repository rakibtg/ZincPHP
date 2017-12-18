<?php
  require_once './app/core/zinc_dbm/ZincDBManager.php';
  $zincDBManager = new ZincDBManager();
  if( $zincDBManager->isMigrationFileExists( $argv[2] ) ) {
    $migratableFile = $zincDBManager->prepareMigrationFileName( $argv[2] );
    echo \OutputCLI\warn( "Trying to Migrate:" ) . basename( $migratableFile );
    // Check if the file was already migrated or not.
    if( ! $zincDBManager->ifMigrated( $migratableFile ) ) {
      require_once $migratableFile;
      $className = trim( rtrim( basename( $migratableFile ), '.php' ) );
      $__migrate = new $className( $zincDBManager );
      $__migrate->up();
      unset( $__migrate );
      // Add current migration as migrated.
      $zincDBManager->addAsMigrated( $migratableFile );
    } else {
      echo \OutputCLI\nl();
      echo \OutputCLI\danger( basename( $migratableFile ) . ' was already migrated, do you want to force migrate? (y/n)' );
      $handle = fopen( "php://stdin", "r" );
      $cont   = trim( fgets( $handle ) );
      if( strtolower( $cont ) == 'y' ) {
        echo \OutputCLI\warn( "Force migrating:" ) . basename( $migratableFile );
        require_once $migratableFile;
        $className = trim( rtrim( basename( $migratableFile ), '.php' ) );
        $__migrate = new $className( $zincDBManager );
        $__migrate->up();
        unset( $__migrate );
      } else {
        echo \OutputCLI\warn( 'Nothing to migrate' );
        echo \OutputCLI\nl();
      }
    }
  } else {
    echo \OutputCLI\danger( 'Migration file was not found' );
    echo \OutputCLI\nl();
    echo \OutputCLI\warn( 'Looking for:' );
    echo $zincDBManager->prepareMigrationFileName( $argv[2] );
    echo \OutputCLI\nl();
  }
  exit();