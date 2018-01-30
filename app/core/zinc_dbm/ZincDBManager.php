<?php

  require_once './app/core/zinc_dbm/ColumnsTrait.php';
  require_once './app/core/zinc_dbm/ModifiersTrait.php';
  require_once './app/core/zinc_dbm/MigrationTrait.php';
  require_once './app/core/zinc_dbm/TablesTrait.php';
  require_once './app/core/zinc_dbm/ZincPHPMigrater.php';

  class ZincDBManager {

    use ColumnsTrait, ModifiersTrait, MigrationTrait, TablesTrait;

    /**
     * The begining query of the SQL
     *
     * @var string $queryHead
     */
    private $queryHead;

    /**
     * The body the SQL query, contains all the columns query.
     *
     * @var string $queryBody
     */
    private $queryBody;

    /**
     * The ending of the SQL query, contains table config related.
     *
     * @var string $queryFoot
     */
    private $queryFoot;

    /**
     * Contains a RAW SQL Query.
     *
     * @var string $rawQuery;
     */
    private $rawQuery;

    /**
     * Table to be affected.
     *
     * @var string $tableName
     */
    private $tableName;

    /**
     * Application environment settings.
     *
     * @var object $env
     */
    private $env;

    /**
     * Connection variable for MySQL.
     *
     * @var object $db
     */
    private $db;

    function __construct() {

      $this->queryHead = '';
      $this->queryBody = '';
      $this->queryFoot = '';
      $this->tableName = '';
      $this->rawQuery  = false; // If the value is not false then the build method will only return its value.

      // Get environment settings from environment document
      $this->env = json_decode( file_get_contents( './app/environment.json' ) );

      // New mysql connection.
      if(!$this->db = mysqli_connect(
        $this->env->host,
        $this->env->database_user,
        $this->env->database_password,
        $this->env->database
      )){
        print \ZincPHP\CLI\Helper\danger("Error: Unable to connect with the database. Edit environment.json file and check your database configurations.");
        \ZincPHP\CLI\Helper\nl();
        print 'Error Message: ' . mysqli_connect_error();
        \ZincPHP\CLI\Helper\nl();
      }
    }

    /**
     * Run a plain raw sql query in the migration.
     *
     * @param   string  $sqlQuery  The sql query as a string.
     * @return  object  ...        Current object.
     */
    function rawQuery( $sqlQuery ) {
      $this->rawQuery = $sqlQuery;
      return $this;
    }

    /**
     * The final query to create a table.
     *
     * @return  string  The queryable string.
     */
    function build() {
      if( $this->rawQuery ) {
        $finalQuery = $this->rawQuery;
      } else {
        // Process body
        $this->queryBody = trim( $this->queryBody );
        $this->queryBody = trim( $this->queryBody, ',' );
        // Process header
        $this->queryHead = trim( $this->queryHead );
        // Process footer
        $this->queryFoot = trim( $this->queryFoot );
        // Final query.
        $finalQuery =  $this->queryHead . ' (' . $this->queryBody . ' ) ' . $this->queryFoot . ";";
      }
      return $finalQuery;
    }

    /**
     * Destroy recent build of the SQL query.
     *
     */
    function destroyBuild() {
      // Reset query strings.
      $this->queryHead = '';
      $this->queryBody = '';
      $this->queryFoot = '';
      $this->rawQuery  = false;
    }

    /**
     * Executes command to create the table.
     *
     * @return boolean
     */
    function query() {
      if( ! $this->db ) exit();
      $execQuery = mysqli_query( $this->db, trim( $this->build() ) );
      if( $execQuery !== true ) {
        return (string) mysqli_error( $this->db );
      }
      // Resetting the recent build.
      $this->destroyBuild();
      // Everything just works.
      return true;
    }

  }
