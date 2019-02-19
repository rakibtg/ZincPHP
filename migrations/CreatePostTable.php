<?php

  /*
    A migration file has two method one is up() and down().
    -> up() method is responsible to create/update tables.
    -> down() method is responsible to undo changes occurred by up() method.
    -> ZincPHP will add the auto incremented `id` column by default.
  */

  class CreatePostTable {

    function up( $schema ) {
      $schema->create( 'posts', function ( $table ) {
        $table->increments('id');
        $table->integer('author');
        $table->string('title');
        $table->timestamps();
      });
    }

    function down( $schema ) {
      // Drop the table.
      $schema->drop( 'posts' );
    }
  }