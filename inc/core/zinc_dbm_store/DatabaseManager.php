<?php

  require_once './ColumnsTrait.php';

  class DatabaseManager {

    use ColumnsTrait;

    private $queryHead;
    private $queryBody;
    private $queryFoot;
    private $tableName;

    function __construct() {
      $this->queryHead = '';
      $this->queryBody = '';
      $this->queryFoot = '';
      $this->tableName = '';
    }

    function create( $table ) {
      $this->tableName = $table;
      $this->queryHead .= 'CREATE TABLE ' . $table . ' ';
      return $this;
    }

    function build() {
      // Process body
      $this->queryBody = trim( $this->queryBody );
      $this->queryBody = trim( $this->queryBody, ',' );
      // Process header
      $this->queryHead = trim( $this->queryHead );
      // Process footer
      $this->queryFoot = trim( $this->queryFoot );
      return $this->queryHead . ' (' . $this->queryBody . ') ' . $this->queryFoot;
    }

  }

  $dm = new DatabaseManager();

  $dm->create('users')
    ->increments('id')
    ->integer('age')
  ->string('full_name', 50);

  echo $dm->build();