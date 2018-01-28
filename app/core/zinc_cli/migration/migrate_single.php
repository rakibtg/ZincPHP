<?php
  require_once './app/core/zinc_dbm/ZincDBManager.php';
  $zincDBManager = new ZincDBManager();
  if( $zincDBManager->isMigrationFileExists( $argv[2] ) ) {
    $migratableFile = $zincDBManager->prepareMigrationFileName( $argv[2] );
    echo \ZincPHP\CLI\Helper\warn( "Trying to Migrate:" ) . basename( $migratableFile );
    // Check if the file was already migrated or not.
    if( ! $zincDBManager->ifMigrated( $migratableFile ) ) {
      require_once $migratableFile;
      $className    = trim( rtrim( basename( $migratableFile ), '.php' ) );
      $__migrate    = new $className( $zincDBManager );
      $__migrateUp  = $__migrate->up();
      if( $__migrateUp === true ) {
        // Add current migration as migrated.
        $zincDBManager->addAsMigrated( $migratableFile );
        print \ZincPHP\CLI\Helper\success(" (Success)");
        \ZincPHP\CLI\Helper\nl();
      } else {
        print \ZincPHP\CLI\Helper\danger( " (Failed)" );
        \ZincPHP\CLI\Helper\nl();
        print '> ' . $__migrateUp;
        \ZincPHP\CLI\Helper\nl();
      }
      unset( $__migrate );
    } else {
      echo \ZincPHP\CLI\Helper\nl();
      echo \ZincPHP\CLI\Helper\danger( basename( $migratableFile ) . ' was already migrated, do you want to force migrate? (y/n)' );
      $handle = fopen( "php://stdin", "r" );
      $cont   = trim( fgets( $handle ) );
      if( strtolower( $cont ) == 'y' ) {
        echo \ZincPHP\CLI\Helper\warn( "Force migrating:" ) . basename( $migratableFile );
        require_once $migratableFile;
        $className    = trim( rtrim( basename( $migratableFile ), '.php' ) );
        $__migrate    = new $className( $zincDBManager );
        $__migrateUp  = $__migrate->up();
        if( $__migrateUp === true ) {
          print \ZincPHP\CLI\Helper\success(" (Success)");
          \ZincPHP\CLI\Helper\nl();
        } else {
          print \ZincPHP\CLI\Helper\danger( " (Failed)" );
          \ZincPHP\CLI\Helper\nl();
          print '> ' . $__migrateUp;
          \ZincPHP\CLI\Helper\nl();
        }
        unset( $__migrate );
      } else {
        echo \ZincPHP\CLI\Helper\warn( 'Nothing to migrate' );
        echo \ZincPHP\CLI\Helper\nl();
      }
    }
  } else {
    echo \ZincPHP\CLI\Helper\danger( 'Migration file was not found' );
    echo \ZincPHP\CLI\Helper\nl();
    echo \ZincPHP\CLI\Helper\warn( 'Looking for:' );
    echo $zincDBManager->prepareMigrationFileName( $argv[2] );
    echo \ZincPHP\CLI\Helper\nl();
  }
  exit();