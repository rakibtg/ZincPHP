<?php

  /**
   * New migration schema of a table.
   *
   */
  class RenameDreamPostsTable {
    private $db; // DO NOT CHANGE THIS LINE
    function __construct( $dbm ) { $this->db = $dbm; } // DO NOT CHANGE THIS LINE

    function up() {
      // Add new columns here.
      // $this->db->renameTable( 'dreamy1', 'dreamy_love' )->query();
      return $this->db->selectTable( 'RawColumnTest' )->renameColumn( 'holly_molly', 'ohYeahs', 'VARCHAR' )->query();
    }

  }
