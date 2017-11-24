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
      $this->zincDBManager->create( 'dream_posts' )
        ->increments( 'id' )
        ->string( 'title' )
        ->text( 'content' )
        ->integer( 'author' )
      ->executeCreateTable();
    }

    function down() {
      $this->zincDBManager->drop( 'dream_posts' );
    }

  }
