<?php

  /**
   * This class is use to migrate a database operation.
   *
   */

  class ZincPHPMigrater {

    /**
     * Contains the ZincDBManager instance to execute the query in the database.
     * @var   object   $db
     *
     */
    public $db;

    /**
     * Contains the table name for the DB operations.
     * @var   string   $table
     *
     */
    public $table;

    // Assign above values.
    function __construct( $dbManager ) {
      $this->db = $dbManager;
    }

  }