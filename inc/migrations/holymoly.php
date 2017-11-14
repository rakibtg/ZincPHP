<?php

  /**
   * New migration schema of a table.
   *
   */
  class Migration {
    private $zincDBManager; // DO NOT CHANGE THIS LINE
    function __construct( $dbm ) { $this->zincDBManager = $dbm; } // DO NOT CHANGE THIS LINE

    function up() {
      // Add new columns here.
      $this->zincDBManager->create( 'holymoly' )
        ->increments( 'id' )
        ->string( 'name', 50 )
        ->string( 'username', 20 )->unique()
        ->text( 'bio', 500 )->nullable()
      ->executeCreateTable();
    }
  }
