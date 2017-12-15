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
    echo \OutputCLI\warn( "Nothing to migrate." );
    echo \OutputCLI\nl();
    exit();
  } else {
    $nothingToMigrate = true;
  }

  // Migrate each file.
  foreach( $migratable as $mfile ) {
    // echo $mfile;
    // echo "\n";
    
    if( $zincDBManager->addAsMigrated( $mfile ) ) {
      print \OutputCLI\warn( "Trying to Migrate:" ) . basename( $mfile );
      // echo \OutputCLI\nl();
      require_once $mfile;
      $className = trim( rtrim( basename( $mfile ), '.php' ) );
      $g = new $className( $zincDBManager );
      if( $g->up() ) {
        echo \OutputCLI\success( ' (Success)' );
        echo \OutputCLI\nl();
      } else {
        echo \OutputCLI\danger( ' (Failed)' );
        echo \OutputCLI\nl();
      }
      unset($g);
      $nothingToMigrate = false;
    }
  }

  if( $nothingToMigrate ) {
    echo \OutputCLI\warn( "Nothing to migrate." );
    echo \OutputCLI\nl();
    exit();
  }

  echo \OutputCLI\nl();
  exit(); // End cli execution.
