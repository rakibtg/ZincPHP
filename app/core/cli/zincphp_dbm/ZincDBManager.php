<?php

  // Autoload files using Composer autoload
  if ( file_exists( __DIR__ . '/../../../vendor/autoload.php' ) ) require_once __DIR__ . '/../../../vendor/autoload.php';

  require_once __DIR__ . '/ColumnsTrait.php';
  require_once __DIR__ . '/ModifiersTrait.php';
  require_once __DIR__ . '/MigrationTrait.php';
  require_once __DIR__ . '/TablesTrait.php';
  require_once __DIR__ . '/ZincPHPMigrater.php';
  require_once __DIR__ . '/SeedsTrait.php';
  require_once __DIR__ . '/../zinc/Zinc.php';
  require_once __DIR__ . '/../app_getter/App.php';

  class ZincDBManager {

    use ColumnsTrait, ModifiersTrait, MigrationTrait, TablesTrait, SeedsTrait;

    /**
     * The begining query of the SQL
     *
     * @var string $queryHead
     */
    protected $queryHead;

    /**
     * The body the SQL query, contains all the columns query.
     *
     * @var string $queryBody
     */
    protected $queryBody;

    /**
     * The ending of the SQL query, contains table config related.
     *
     * @var string $queryFoot
     */
    protected $queryFoot;

    /**
     * Contains a RAW SQL Query.
     *
     * @var string $rawQuery;
     */
    protected $rawQuery;

    /**
     * Table to be affected.
     *
     * @var string $tableName
     */
    protected $tableName;

    function __construct() {

      $this->queryHead = '';
      $this->queryBody = '';
      $this->queryFoot = '';
      $this->tableName = '';
      $this->rawQuery  = false; // If the value is not false then the build method will only return its value.
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
      $zpEnv = (array) \App::environment()->database_config;
      $connection = new \Pixie\Connection( $zpEnv[ 'driver' ], $zpEnv );
      $qb = new \Pixie\QueryBuilder\QueryBuilderHandler( $connection );
      $qb->query( $this->build() );
      // Resetting the recent build.
      $this->destroyBuild();
      // Everything just works.
      return true;
    }

  }
