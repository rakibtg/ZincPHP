<?php
  require_once './app/core/zinc_dbm/ZincDBManager.php';

  class MigrateRefresh extends ZincDBManager {

    function ask( $argv ) {
      $env = App::environment();

      // Check if database is set to mysql.
      if ( $env->database_config->driver != 'mysql' ) {
        echo \ZincPHP\CLI\Helper\danger( 
          '❗ migrate:refresh command is only available for mysql database at this moment.' 
        );
        echo \ZincPHP\CLI\Helper\nl();        
      }

      // Show user warning message.
      echo \ZincPHP\CLI\Helper\danger( 
        'Are you sure you want to empty the database "'.$env->database_config->database.'"? (y/n)' 
      );
      $handle = fopen( "php://stdin", "r" );
      $cont   = trim( fgets( $handle ) );
      if( strtolower( $cont ) == 'y' ) {
        $success = false;
        // Drop the database.
        echo 'Cleaning "'.$env->database_config->database.'" database';
        echo \ZincPHP\CLI\Helper\nl();
        $this->rawQuery = 'DROP database `'.$env->database_config->database.'`;';
        $_q = $this->query();
        if( $_q === true ) {
          echo \ZincPHP\CLI\Helper\success( '✅ ' );
          echo 'Database dropped.';
          echo \ZincPHP\CLI\Helper\nl();
          $success = true;
        } else {
          echo \ZincPHP\CLI\Helper\danger( '⛔️ ' );
          echo 'Failed: ' . $_q;
          echo \ZincPHP\CLI\Helper\nl();
        }

        // Create the database, create connection.
        $conn = new mysqli( 
          $env->database_config->host, $env->database_config->username, $env->database_config->password 
        );
        // Check connection
        if ($conn->connect_error) {
          die( "Connection failed: " . $conn->connect_error );
        } 

        // Create database
        $sql = "CREATE DATABASE `".$env->database_config->database."`";
        if ($conn->query($sql) === TRUE) {
          echo \ZincPHP\CLI\Helper\success( '✅ ' );
          echo 'Database created.';
          echo \ZincPHP\CLI\Helper\nl();
          $success = true;
        } else {
          echo \ZincPHP\CLI\Helper\danger( '⛔️ ' );
          echo 'Failed: ' . $conn->error;
          echo \ZincPHP\CLI\Helper\nl();
        }

        $conn->close();
      
        if( $success === true ) {

          // Empty the migration list document.
          if( file_exists( './app/core/zinc_cli/migration/migrationlist.json' ) ) {
            file_put_contents( './app/core/zinc_cli/migration/migrationlist.json', '[]' );
          }

          echo \ZincPHP\CLI\Helper\success( '✅  Successfully cleaned the database.' );
          echo \ZincPHP\CLI\Helper\nl();
          
          echo '➡️  Migrating the database';
          echo \ZincPHP\CLI\Helper\nl();

          // Migrate again.
          $this->migrateUp();

          // Check do we have to seed too.
          if( in_array( '--seed', $argv ) ) {
            echo '➡️  Trying to seed data.';
            echo \ZincPHP\CLI\Helper\nl();
            $this->seed( false );
          }

        } else {
          echo \ZincPHP\CLI\Helper\danger( 'Failed to clean the database.' );
          echo \ZincPHP\CLI\Helper\nl();
        }
      } else {
        echo 'Action canceled';
        echo \ZincPHP\CLI\Helper\nl();
      }
    }

  }

  // Ask the user if he/she want to really empty the database.
  ( new MigrateRefresh() )->ask( $argv );

  

  exit();
