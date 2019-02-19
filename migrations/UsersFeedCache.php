<?php

  class UsersFeedCache {

    function up( $schema ) {
      $schema->create('users_feed_cache', function ($table) {
        $table->increments('id');
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamps();
      });
    }

    function down( $schema ) {
      $schema->drop( 'users_feed_cache' );
    }

  }