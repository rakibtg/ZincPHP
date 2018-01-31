<?php

  /**
   * Yet another migration class.
   * To learn more about migrations go here: http://...
   *
   */

  class UsersInfo extends ZincPHPMigrater {

    function up () {
      return $this->db->createTable( 'users-info' )
        ->increments( 'id' )
        ->string('name')
        ->integer('guest_id')->unsigned()
        ->foreignKey('guest_id', 'MyGuests', 'id')
      ->query();
    }

  }
