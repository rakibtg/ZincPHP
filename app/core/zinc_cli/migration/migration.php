<?php
  require_once './app/core/zinc_dbm/ZincDBManager.php';
  
  $zincDBManager = new ZincDBManager();
  // $g = new Migration( $zincDBManager );
  // $g->up();
  // list all php files.
  // print_r( $zincDBManager->listAllMigrations() );
  // print_r( $zincDBManager->readMigrationList() );
  // print_r( $zincDBManager->addAsMigrated( 'family' ) );
  // exit();
  $migratable = $zincDBManager->listAllMigrations();

  if( empty( $migratable ) ) {
    echo \OuputCLI\warn( "Nothing to migrate." );
    echo \OuputCLI\nl();
    exit();
  } else {
    $nothingToMigrate = true;
  }

  // Migrate each file.
  foreach( $migratable as $mfile ) {
    // echo $mfile;
    // echo "\n";
    
    if( $zincDBManager->addAsMigrated( $mfile ) ) {
      print \OuputCLI\warn( "Trying to Migrate:" ) . basename( $mfile );
      // echo \OuputCLI\nl();
      require_once $mfile;
      $className = trim( rtrim( basename( $mfile ), '.php' ) );
      $g = new $className( $zincDBManager );
      if( $g->up() ) {
        echo \OuputCLI\success( ' (Success)' );
        echo \OuputCLI\nl();
      } else {
        echo \OuputCLI\danger( ' (Failed)' );
        echo \OuputCLI\nl();
      }
      unset($g);
      $nothingToMigrate = false;
    }
  }

  if( $nothingToMigrate ) {
    echo \OuputCLI\warn( "Nothing to migrate." );
    echo \OuputCLI\nl();
    exit();
  }

  echo \OuputCLI\nl();
  exit(); // End cli execution.
