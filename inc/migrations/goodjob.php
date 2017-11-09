<?php

  /**
   * New migration schema of a table.
   *
   */
  class Migration {
    private $zincDBManager;
    function __construct( $dbm ) { $this->zincDBManager = $dbm; }

    function up() {
      // -------------------------
      // Make changes here
      // Add new columns
      // -------------------------
      $this->zincDBManager->create( 'table_name' )
        ->increments( 'id' )
      ->executeCreateTable();
    }
  }
