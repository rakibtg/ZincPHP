<?php

  /**
   * New migration schema of a table.
   *
   */
  class Rawcolumntest {
    private $db; // DO NOT CHANGE THIS LINE
    function __construct( $dbm ) { $this->db = $dbm; } // DO NOT CHANGE THIS LINE

    function up() {
      // Add new columns here.
      return $this->db->createTable( 'RawColumnTest' )
        ->increments( 'id' )
        ->rawColumn( 'holly_molly VARCHAR(199) NOT NULL DEFAULT "no cool man"' )
      ->query();
    }

    function down() {
      return $this->db->dropTable( 'RawColumnTest' );
    }
    
  }
