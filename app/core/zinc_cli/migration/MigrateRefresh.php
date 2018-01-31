<?php
  require_once './app/core/zinc_dbm/ZincDBManager.php';

  class MigrateRefresh extends ZincDBManager {
    function ask() {
      // Show user warning message.
      echo \ZincPHP\CLI\Helper\danger( 'Are you sure you want to empty the database "'.$this->env->database.'"? (y/n)' );
      $handle = fopen( "php://stdin", "r" );
      $cont   = trim( fgets( $handle ) );
      if( strtolower( $cont ) == 'y' ) {
        $success = false;
        // Drop the database.
        echo 'Cleaning "'.$this->env->database.'" database';
        echo \ZincPHP\CLI\Helper\nl();
        $this->rawQuery = 'DROP database `'.$this->env->database.'`;';
        $_q = $this->query();
        if( $_q === true ) {
          echo \ZincPHP\CLI\Helper\success( '✔ ' );
          echo 'Database dropped.';
          echo \ZincPHP\CLI\Helper\nl();
          $success = true;
        } else {
          echo \ZincPHP\CLI\Helper\danger( '✘ ' );
          echo 'Failed: ' . $_q;
          echo \ZincPHP\CLI\Helper\nl();
        }

        // Create the database.
        $this->rawQuery = 'CREATE database `'.$this->env->database.'`;';
        $_q = $this->query();
        if( $_q === true ) {
          echo \ZincPHP\CLI\Helper\success( '✔ ' );
          echo 'Database created.';
          echo \ZincPHP\CLI\Helper\nl();
          $success = true;
        } else {
          echo \ZincPHP\CLI\Helper\danger( '✘ ' );
          echo 'Failed: ' . $_q;
          echo \ZincPHP\CLI\Helper\nl();
        }
        if( $success === true ) {

          // Empty the migration list document.
          if( file_exists( './app/core/zinc_cli/migration/migrationlist.json' ) ) {
            file_put_contents( './app/core/zinc_cli/migration/migrationlist.json', '[]' );
          }
          echo \ZincPHP\CLI\Helper\success( 'Successfully cleaned the database.' );
          echo \ZincPHP\CLI\Helper\nl();

          // Use current database.
          $this->useDatabase();
          echo '➤ Using database ' . $this->env->database;
          echo \ZincPHP\CLI\Helper\nl();

          // Migrate again.
          $this->migrateUp();

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

  ( new MigrateRefresh() )->ask();

  exit();
