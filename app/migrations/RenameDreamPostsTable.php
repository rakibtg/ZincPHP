<?php

  /**
   * New migration schema of a table.
   *
   */
  class Renamedreampoststable {
    private $zincDBManager; // DO NOT CHANGE THIS LINE
    function __construct( $dbm ) { $this->zincDBManager = $dbm; } // DO NOT CHANGE THIS LINE

    function up() {
      // Add new columns here.
      $this->zincDBManager->rename( 'dream_posts_7', 'dreamy' )->executeCreateTable();
    }

    // function down() {
    //   $this->zincDBManager->dropTable( 'RenameDreamPostsTable' );
    // }
    
  }
