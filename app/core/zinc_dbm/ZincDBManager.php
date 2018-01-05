<?php

  require_once './app/core/zinc_dbm/ColumnsTrait.php';
  require_once './app/core/zinc_dbm/ModifiersTrait.php';
  require_once './app/core/zinc_dbm/MigrationTrait.php';

  class ZincDBManager {

    use ColumnsTrait, ModifiersTrait, MigrationTrait;

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
        print \OutputCLI\danger("Error: Unable to connect with the database. Edit environment.json file and check your database configurations.");
        \OutputCLI\nl();
        print 'Error Message: ' . mysqli_connect_error();
        \OutputCLI\nl();
      }
    }

    /**
     * Sets the table name.
     * 
     * @param   string  $table  The table name
     * @return  object          Current object
     */
    function selectTable( $table ) {
      $this->tableName = $table;
      return $this;
    }

    /**
     * Starts to establishing the SQL command for creating a table.
     *
     * @param     string    $table    The table name that should be affected.
     * @return    object    Current object.
     */
    function createTable( $table ) {
      $this->tableName  = $table;
      $this->queryHead .= ' CREATE TABLE ' . $table . ' ';
      return $this;
    }

    /**
     * Make the SQL command required to rename a table.
     * 
     * @param   string   $old   Old name of the table, that we want to rename.
     * @param   string   $new   New name for the table.
     * @return  object          Current object.
     */
    function renameTable( $old, $new ) {
      $this->tableName = $old; // Table to be affected.
      $this->rawQuery  = 'RENAME TABLE `'.$old.'` TO `'.$new . '`; ';
      return $this;
    }

    /**
     * Will soon work on drop table.
     */
    function dropTable() {
      return false;
    }

    /**
     * The final query to create a table.
     *
     * @return string The queryable string.
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
    function executeCreateTable() {
      if(!$this->db) exit();
      if( ! mysqli_query( $this->db, trim( $this->build() ) ) ) {
        print \OutputCLI\danger( " (Failed)" );
        \OutputCLI\nl();
        print '> ' . mysqli_error( $this->db );
        \OutputCLI\nl();
        return false;
      } else {
        print \OutputCLI\success(" (Success)");
        \OutputCLI\nl();
        return true;
      }
      // Resetting the recent build.
      $this->destroyBuild();
    }

  }