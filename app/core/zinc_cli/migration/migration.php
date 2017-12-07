<?php
  require_once './app/core/zinc_dbm/ZincDBManager.php';
  
  $zincDBManager = new ZincDBManager();
  // $g = new Migration( $zincDBManager );
  // $g->up();
  // list all php files.
  // print_r( $zincDBManager->listAllMigrations() );
  $migratable = $zincDBManager->listAllMigrations();

  if( empty( $migratable ) ) exit( \OuputCLI\warn( "\n Nothing to migrate.\n\n" ) );

  // Migrate each file.
  foreach( $migratable as $mfile ) {
    print \OuputCLI\success( "Migrating:" ) . basename( $mfile ) . "\n";
    require_once $mfile;
    $className = trim( rtrim( basename( $mfile ), '.php' ) );
    $g = new $className( $zincDBManager );
    $g->up();
    unset($g);
  }
  print "\n";
  exit(); // End cli execution.
