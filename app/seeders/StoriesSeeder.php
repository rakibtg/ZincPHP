<?php

  /**
   * DreamPostsSeeder Database Seeder
   * To learn more about seeding data go here: http://...
   * 
   */

  class StoriesSeeder extends ZincDBManager {

    /**
     * Runs the seeder.
     * @param   object   $db   ZincPHP MySQL database instance.
     */
    function run ( $db ) {

      return $db->table( 'stories' )->insert( [
        [
          'title' => 'How its possible.',
          'content' => 'Am i realy gonna make a framework?',
          'author' => 31,
        ],
        [
          'title' => 'My love bird',
          'content' => 'I used to have a pair of love bird at 2009',
          'author' => 10,
        ],
        [
          'title' => 'Will it work at the first try?',
          'content' => 'Just testing the seeder for the first time.',
          'author' => 14,
        ],
        [
          'title' => 'VSCode is best',
          'content' => 'I have had some feeling for Atom :D',
          'author' => 4,
        ],
      ] );

    }

  }