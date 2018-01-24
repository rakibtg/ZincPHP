<?php

  trait ModifiersTrait {

    // Place the column "after" another column (MySQL)
    function after( $columnName ) {
      $this->queryBody .= ' AFTER `'.$columnName.'` ';
      return $this;
    }

    // Set INTEGER columns as auto-increment (primary key)
    function autoIncrement() {
      $this->queryBody .= ' AUTO_INCREMENT ';
      return $this;
    }

    // Specify a character set for the column (MySQL)
    function charsetColumn( $encoding = 'utf8' ) {
      $this->queryBody .= ' CHARACTER SET '.$encoding.' ';
      return $this;
    }

    // Specify a collation for the table (MySQL/SQL Server)
    function collationColumn( $encoding = 'utf8_unicode_ci' ) {
      $this->queryBody .= ' COLLATE '.$encoding.' ';
      return $this;
    }

    // Add a comment to a column (MySQL)
    function commentColumn( $msg = '' ) {
      $this->queryBody .= ' /*'.$msg.'*/ ';
      return $this;
    }

    // Specify a "default" value for the column
    function default( $val ) {
      $this->queryBody .= ' DEFAULT "'.$val.'" ';
      return $this;
    }

    // Allows (by default) NULL values to be inserted into the column
    function nullable() {
      $this->queryBody .= ' NULL ';
      return $this;
    }

    // Makes a field not nullable
    function notNull() {
      $this->queryBody .= ' NOT NULL ';
      return $this;
    }

    // Set INTEGER columns as UNSIGNED (MySQL)
    function unsigned() {
      $this->queryBody .= ' UNSIGNED ';
      return $this;
    }

    // Set TIMESTAMP columns to use CURRENT_TIMESTAMP as default value
    function useCurrent() {
      $this->queryBody .= ' DEFAULT CURRENT_TIMESTAMP ';
      return $this;
    }

  }
