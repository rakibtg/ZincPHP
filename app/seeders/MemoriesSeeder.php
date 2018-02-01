<?php

  /**
   * MemoriesSeeder Database Seeder.
   * To insert single item use insert() method.
   * To insert multiple item use insertMany() method.
   * 
   */

  class MemoriesSeeder extends ZincDBManager {

    /**
     * Runs the seeder.
     *
     * @param   object   $db   ZincPHP MySQL database instance.
     *                         $db is instantiated in its parent extended class.
     */
    function run ( $db ) {

      $db->insert( 'memories', [
        'title' => 'That night i never forgot',
        'content' => 'When i have descided to make ZincPHP.'
      ] );

    }

  }