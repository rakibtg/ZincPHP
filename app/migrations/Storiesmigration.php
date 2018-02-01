<?php

  /**
   * Yet another migration class.
   * To learn more about migrations go here: http://...
   * 
   */

  class Storiesmigration extends ZincPHPMigrater {

    function up () {
      return $this->db->createTable( 'stories' )
        ->increments( 'id' )
        ->string( 'title' )
        ->text( 'content' )
        ->integer( 'author' )
      ->query();
    }

  }