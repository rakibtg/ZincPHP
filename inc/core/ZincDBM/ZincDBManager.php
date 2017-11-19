<?php

  require_once './inc/core/ZincDBM/ColumnsTrait.php';
  require_once './inc/core/ZincDBM/ModifiersTrait.php';
  require_once './inc/core/ZincDBM/MigrationTrait.php';

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

      // Get environment settings from environment document
      $this->env = json_decode( file_get_contents( './environment.json' ) );

      // New mysql connection.
      $this->db = mysqli_connect(
        $this->env->host,
        $this->env->database_user,
        $this->env->database_password,
        $this->env->database
      );

    }

    /**
     * Starts to establishing the SQL command for creating a table.
     *
     * @param     string    $table    The table name that should be affected.
     * @return    object    Current object.
     */
    function create( $table ) {
      $this->tableName = $table;
      $this->queryHead .= 'CREATE TABLE ' . $table . ' ';
      return $this;
    }

    /**
     * The final query to create a table.
     *
     * @return string
     */
    function build() {
      // Process body
      $this->queryBody = trim( $this->queryBody );
      $this->queryBody = trim( $this->queryBody, ',' );
      // Process header
      $this->queryHead = trim( $this->queryHead );
      // Process footer
      $this->queryFoot = trim( $this->queryFoot );
      // Final query.
      $finalQuery =  $this->queryHead . ' (' . $this->queryBody . ' ) ' . $this->queryFoot . ";";
      // Reset query strings.
      $this->queryHead = '';
      $this->queryBody = '';
      $this->queryFoot = '';
      return $finalQuery;
    }

    /**
     * Executes command to create the table.
     *
     * @return void
     */
    function executeCreateTable() {
      if( mysqli_query( $this->db, $this->build() ) ) {
        print "Table (".$this->tableName.") created successfully\n";
      } else {
        print \OuputCLI\danger( "Error:" ) . mysqli_error( $this->db ) . "\n";
      }
    }

  }

  // $dm = new ZincDBManager();

  // $dm->create('usersxyzyzyzyzyzyzzy')
  //   ->increments('id')
  //   ->integer('age')->nullable()
  //   ->string('full_name', 50)->nullable()
  // ->charset()->collation();

  // echo $dm->executeCreateTable();
