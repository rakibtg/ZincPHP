<?php

  use \ZincPHP\CLI\Helper as CLI;

  require_once __DIR__ . '/../zincphp_dbm/ZincDBManager.php';

  class MigrateRefresh extends \ZincPHP\Database\Manager\ZincDBManager {

    function ask( $argv ) {
      $env = \App::environment();

      // Check if database is set to mysql.
      if ( $env->database_config->driver != 'mysql' ) {
        echo CLI\danger( 
          '❗ migrate:refresh command is only available for mysql database at this moment.' 
        );
        echo CLI\nl();
      }

      // Show user warning message.
      echo CLI\danger( 
        'Are you sure you want to empty the database "'.$env->database_config->database.'"? (y/n)' 
      );
      $handle = fopen( "php://stdin", "r" );
      $cont   = trim( fgets( $handle ) );
      if( strtolower( $cont ) == 'y' ) {
        $success = false;
        // Drop the database.
        echo 'Cleaning "'.$env->database_config->database.'" database';
        echo CLI\nl();
        try {
          \App::db()->raw( 'DROP database `'.$env->database_config->database.'`;' );
          echo CLI\success( '✅ ' );
          echo 'Database dropped.';
          echo CLI\nl();
          $success = true;
        } catch( Exception $e ) {
          CLI\nl();
          CLI\nl();
          print CLI\danger( "Error Message:" );
          echo $e->getMessage();
          CLI\nl();
          CLI\nl();
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
        try {
          \App::db()->raw( "CREATE DATABASE `".$env->database_config->database."`" );
          echo CLI\success( '✅ ' );
          echo 'Database created.';
          echo CLI\nl();
          $success = true;
        } catch( Exception $e ) {
          CLI\nl();
          CLI\nl();
          print CLI\danger( "Error Message:" );
          echo $e->getMessage();
          CLI\nl();
          CLI\nl();
        }

        $conn->close();

        // Use database
        try {
          \App::db()->raw( "USE `".$env->database_config->database."`" );
          echo CLI\success( '✅ ' );
          echo 'Database selected.';
          echo CLI\nl();
          $success = true;
        } catch( Exception $e ) {
          CLI\nl();
          CLI\nl();
          print CLI\danger( "Error Message:" );
          echo $e->getMessage();
          CLI\nl();
          CLI\nl();
        }
      
        if( $success === true ) {

          // Empty the migration list document.
          if( file_exists( './app/core/cli/migration/migrationlist.json' ) ) {
            file_put_contents( './app/core/cli/migration/migrationlist.json', '[]' );
          }
          
          echo '➡️  Migrating the database';
          echo CLI\nl();

          // Migrate again.
          $this->migrateUp();

          // Check do we have to seed too.
          if( in_array( '--seed', $argv ) ) {
            echo '➡️  Trying to seed data.';
            echo CLI\nl();
            $this->seed( false );
          }

        } else {
          echo CLI\danger( 'Failed to clean the database.' );
          echo CLI\nl();
        }
      } else {
        echo 'Action canceled';
        echo CLI\nl();
      }
    }

  }

  // Ask the user if he/she want to really empty the database.
  ( new MigrateRefresh() )->ask( $argv );

  exit();