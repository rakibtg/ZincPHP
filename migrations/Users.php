<?php

  /*
    A migration file has two method one is up() and down().
    -> up() method is responsible to create/update tables.
    -> down() method is responsible to undo changes occurred by up() method.
    -> ZincPHP will add the auto incremented `id` column by default.
  */

  class Users {

    function up( $schema ) {
      $schema->create( 'users', function ( $table ) {
        $table->increments('id');
        $table->string('name');
        $table->string('email');
        $table->text('bio');
        $table->timestamps();
      });
    }

    function down( $schema ) {
      // Drop the table.
      $schema->drop( 'users' );
    }
  }