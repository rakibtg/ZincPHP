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
     * Construct the class.
     * @param  object  $dbManager  The instantiated object of Zinc database manager.
     */
    function __construct( $dbManager ) {
      $this->db = $dbManager;
    }

  }