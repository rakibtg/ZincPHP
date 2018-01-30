<?php

  /**
   * New migration schema of a table.
   *
   */
  class DreamPosts {
    private $zincDBManager; // DO NOT CHANGE THIS LINE
    function __construct( $dbm ) { $this->zincDBManager = $dbm; } // DO NOT CHANGE THIS LINE

    function up() {
      // Add new columns here.
      return $this->zincDBManager->createTable( 'dream_posts_7' )
        ->increments( 'id' )
        ->string( 'title' )
        ->text( 'content' )
        ->integer( 'author' )
      ->query();
    }

    // function down() {
    //   $this->zincDBManager->drop( 'dream_posts_1' );
    // }

  }
