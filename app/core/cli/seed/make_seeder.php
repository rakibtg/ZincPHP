<?php

  // Try to create a new seeder file.

  // Validate the seeder file name.
  if( ! isset( $argv[ 2 ] ) ) {
    echo \ZincPHP\CLI\Helper\danger( "✘ No seeder name found" );
    echo \ZincPHP\CLI\Helper\nl();
    exit();
  }
  if( empty( $argv[ 2 ] ) ) {
    echo \ZincPHP\CLI\Helper\warn( "✘ Seeder name cant be empty" );
    echo \ZincPHP\CLI\Helper\nl();
    exit();
  }

  // Instantiate Zinc Database Manager.
  require_once './app/core/cli/zincphp_dbm/ZincDBManager.php';
  $dbManager = new ZincDBManager();

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
        echo \ZincPHP\CLI\Helper\danger( "✘  Ops! Table name is not valid and can not be empty");
        echo \ZincPHP\CLI\Helper\nl();
        echo \ZincPHP\CLI\Helper\warn( "Hint: Use the argument '--table' properly. E.g: --table=users");
        echo \ZincPHP\CLI\Helper\nl();
        exit();
      }
    }
  }

  // Create the seeder file.
  $dbManager->makeSeed( $argv[ 2 ], $tableName );

  exit();