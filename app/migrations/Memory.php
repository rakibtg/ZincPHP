<?php

  /**
   * Yet another migration class.
   * To learn more about migrations go here: http://...
   * 
   */

  class Memory extends ZincPHPMigrater {

    function up () {
      return $this->db->createTable( 'memories' )
        ->increments( 'id' )
        ->string( 'title' )
        ->text( 'content' )
      ->query();
    }

    function down() {
      return $this->db
        ->dropTable( 'memories' )
      ->query();
    }

  }