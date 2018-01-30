<?php

  /**
   * Yet another migration class.
   * To learn more about migrations go here: http://...
   *
   */

  class TestRawMigration extends ZincPHPMigrater {

    function up () {
      return $this->db
        ->rawQuery( '
          CREATE TABLE MyGuests (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            firstname VARCHAR(30) NOT NULL,
            lastname VARCHAR(30) NOT NULL,
            email VARCHAR(50),
            reg_date TIMESTAMP
          )
        ' )
      ->query();
    }

  }
