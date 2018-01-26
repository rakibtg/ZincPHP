<?php
  // Table related methods in this trait.
  trait TablesTrait {

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
     * Make the SQL command required to add a table engine.
     * 
     * @param   string  $engineName  The engine name we want to use for this table.
     * @return  object  Current object.
     */
    function engine( $engineName ) {
      $this->queryFoot = ' ENGINE=' . $engineName . ' ';
      return $this;
    }

    /**
     * Make the SQL command required to add a charset of the table.
     * 
     * @param   string  $charsetLabel  The default charset type we want to use for this table.
     * @return  object  Current object.
     */
    function charset( $charsetLabel ) {
      $this->queryFoot = ' DEFAULT CHARSET=' . $charsetLabel . ' ';
      return $this;
    }

    /**
     * Make the SQL command required to specify a collation for the column (MySQL/SQL Server)
     * 
     * @param   string  $encoding  The default collate type we want to use for this table.
     * @return  object  Current object.
     */
    function collation( $encoding = 'utf8_unicode_ci' ) {
      $this->queryFoot .= ' COLLATE '.$encoding.' ';
      return $this;
    }

    /**
     * SQL command required to drop a table.
     * 
     * @param  string  $tableName  The table name to be dropped.
     * @param  array   $tableName  Array of tables name to be dropped.
     * @return object  Current object.
     */
    function dropTable( $tableName ) {
      // Check if more than one table to drop.
      if ( is_array( $tableName ) ) $tableName = implode( ', ', $tableName );
      $this->rawQuery = 'DROP TABLE `' . $tableName . '`; ';
      return $this;
    }

    /**
     * SQL command required to drop a table if exists.
     * 
     * @param   string  $tableName  The table name to be dropped if exists.
     * @param   array   $tableName  Array of tables name to be dropped if exists.
     * @return  object  Current object.
     */
    function dropTableIfExists( $tableName ) {
      // Check if more than one table to drop.
      if ( is_array( $tableName ) ) $tableName = implode( ', ', $tableName );
      $this->rawQuery = 'DROP TABLE IF EXISTS `' . $tableName . '`; ';
      return $this;
    }

  }