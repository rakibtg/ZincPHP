<?php

  /**
   * New migration schema of a table.
   *
   */
  class Wowow {
    private $zincDBManager; // DO NOT CHANGE THIS LINE
    function __construct( $dbm ) { $this->zincDBManager = $dbm; } // DO NOT CHANGE THIS LINE

    function up() {
      // Add new columns here.
      $this->zincDBManager->createTable( 'yowow' )
        ->increments( 'id' )
        ->string( 'please_work' )
      ->executeCreateTable();
    }

    function down() {
      $this->zincDBManager->dropTable( 'yowow' );
    }
    
  }
