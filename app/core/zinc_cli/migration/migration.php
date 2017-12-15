<?php
  require_once './app/core/zinc_dbm/ZincDBManager.php';
  
  $zincDBManager = new ZincDBManager();
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
    if( $zincDBManager->addAsMigrated( $mfile ) ) {
      print \OutputCLI\warn( "Trying to Migrate:" ) . basename( $mfile );
      require_once $mfile;
      $className = trim( rtrim( basename( $mfile ), '.php' ) );
      $g = new $className( $zincDBManager );
      $g->up();
      unset($g);
      $nothingToMigrate = false;
    }
  }

  if( $nothingToMigrate ) {
    echo \OutputCLI\warn( "Nothing to migrate." );
    echo \OutputCLI\nl();
    exit();
  }
  exit(); // End cli execution.
