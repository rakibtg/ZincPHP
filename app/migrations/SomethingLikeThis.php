<?php

  /**
   * New migration schema of a table.
   *
   */
  class SomethingLikeThis {
    private $zincDBManager; // DO NOT CHANGE THIS LINE
    function __construct( $dbm ) { $this->zincDBManager = $dbm; } // DO NOT CHANGE THIS LINE

    function up() {
      // Add new columns here.
      $this->zincDBManager->create( 'table_name_1' )
        ->increments( 'id' )
        ->string( 'title' )->notNull()
        ->string( 'user_name' )->nullable()
        ->integer( 'dob' )->default( 0 )->notNull()
        ->text( 'comments' )->notNull()
      ->executeCreateTable();
    }
  }
