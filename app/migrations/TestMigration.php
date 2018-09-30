<?php

  function up( $schema ) {
    $schema->create('users', function ($table) {
      $table->increments('id');
      $table->string('name');
      $table->string('email')->unique();
      $table->timestamps();
    });
  }

  function down( $schema ) {
    // Drop the table.
  }