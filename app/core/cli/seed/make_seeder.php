<?php

  use \ZincPHP\CLI\Helper as CLI;

  // Try to create a new seeder file.

  // Validate the seeder file name.
  if( ! isset( $argv[ 2 ] ) ) {
    echo CLI\danger( "✘ No seeder name found" );
    echo CLI\nl();
    exit();
  }
  if( empty( $argv[ 2 ] ) ) {
    echo CLI\warn( "✘ Seeder name cant be empty" );
    echo CLI\nl();
    exit();
  }

  // Instantiate Zinc Database Manager.
  // require_once __DIR__ . '/../zincphp_dbm/ZincDBManager.php';
  $dbManager = new \ZincPHP\Database\Manager\ZincDBManager();

  // Table name flag.
  $tableName = '';

  if( isset( $argv[ 3 ] ) ) {

    // Prepare argument, split it by '=' default.
    $argv3 = explode( '=', $argv[ 3 ] );

    // Checking if --table argument was provided.
    if( $argv3[ 0 ] == '--table' ) {

      // Checking if the table name for this seeder was provided in the system argument.
      if( isset( $argv3[ 1 ] ) && ! empty( $argv3[ 1 ] ) ) {
        $tableName = $argv3[ 1 ];
      }
      
      // Check if the provided table name for this seeder was invalid.
      if( $tableName === false ) {
        echo CLI\danger( "✘  Ops! Table name is not valid and can not be empty");
        echo CLI\nl();
        echo CLI\warn( "Hint: Use the argument '--table' properly. E.g: --table=users");
        echo CLI\nl();
        exit();
      }
    }
  }

  // Create the seeder file.
  $dbManager->makeSeed( $argv[ 2 ], $tableName );

  exit();