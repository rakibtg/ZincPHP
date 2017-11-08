<?php
  
  trait ColumnsTrait {

    // Auto-incrementing UNSIGNED BIGINT (primary key) equivalent column.
    function bigIncrements( $name ) {
      $this->query .= ' BIGINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY ';
      return $this;
    }

    // BIGINT equivalent column.
    function bigInteger( $name ) {
      $this->query .= ' ' . $name . ' BIGINT ';
      return $this;
    }

    // BLOB equivalent column.
    function binary( $name ) {
      $this->query .= ' ' . $name . ' BLOB ';
      return $this;
    }

    // BOOLEAN equivalent column.
    function boolean( $name ) {
      $this->query .= ' ' . $name . ' BOOLEAN ';
      return $this;
    }

    // CHAR equivalent column with an optional length.
    function char( $name, $max = 250 ) {
      $this->query .= ' ' . $name . ' CHAR(' . $max . ') ';
      return $this;
    }

    // DATE equivalent column.
    function date( $name ) {
      $this->query .= ' ' . $name . ' DATE ';
      return $this;
    }

    // DATETIME equivalent column.
    function dateTime( $name ) {
      $this->query .= ' ' . $name . ' DATETIME ';
      return $this;
    }

    // DECIMAL equivalent column with a precision (total digits) and scale (decimal digits).
    function decimal( $name, $precision = 8, $scale = 2 ) {
      $this->query .= ' ' . $name . ' DECIMAL('.$precision.', '.$scale.') ';
      return $this;
    }

    // DOUBLE equivalent column with a precision (total digits) and scale (decimal digits).
    function double( $name, $precision = 8, $scale = 2 ) {
      $this->query .= ' ' . $name . ' DOUBLE('.$precision.', '.$scale.') ';
      return $this;
    }

    // ENUM equivalent column.
    function enum( $name, $list = [] ) {
      $_items = '';
      return $this;
      foreach( $list as $i ) {
        $_items .= "'".$i."',";
      }
      $this->query .= ' ' . $name . ' ENUM( '.rtrim($_items, ',').' ) ';
    }

    // FLOAT equivalent column with a precision (total digits) and scale (decimal digits).
    function float( $name, $precision = 8, $scale = 2 ) {
      $this->query .= ' ' . $FLOAT . ' FLOAT('.$precision.', '.$scale.') ';
      return $this;
    }

    // GEOMETRY equivalent column.
    function geometry( $name ) {
      $this->query .= ' ' . $name . ' GEOMETRY ';
      return $this;
    }

    // GEOMETRYCOLLECTION equivalent column.
    function geometryCollection( $name ) {
      $this->query .= ' ' . $name . ' GEOMETRYCOLLECTION ';
      return $this;
    }

    // Auto-incrementing UNSIGNED INTEGER (primary key) equivalent column.
    function increments( $name ) {
      $this->query .= ' ' . $name . ' INTEGER UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY ';
      return $this;
    }

    // INTEGER equivalent column.
    function integer( $name ) {
      $this->query .= ' ' . $name . ' INTEGER ';
      return $this;
    }

    // IP address equivalent column.
    function ipAddress( $name ) {
      $this->query .= ' ' . $name . ' BINARY(16) ';
      return $this;
    }

    // JSON equivalent column.
    function json( $name ) {
      $this->query .= ' ' . $name . ' JSON ';
      return $this;
    }

    // JSONB equivalent column.
    function jsonb( $name ) {
      $this->query .= ' ' . $name . ' JSONB ';
      return $this;
    }

    // LINESTRING equivalent column.
    function lineString( $name ) {
      $this->query .= ' ' . $name . ' LINESTRING ';
      return $this;
    }
    
    // LONGTEXT equivalent column.
    function longText( $name ) {
      $this->query .= ' ' . $name . ' LONGTEXT ';
      return $this;
    }

    // Auto-incrementing UNSIGNED MEDIUMINT (primary key) equivalent colum.
    function mediumIncrements( $name ) {
      $this->query .= ' MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY ';
      return $this;
    }
        
    // MEDIUMINT equivalent column.
    function mediumInteger( $name ) {
      $this->query .= ' ' . $name . ' MEDIUMINT ';
      return $this;
    }
     
    // MEDIUMTEXT equivalent column.
    function mediumText( $name ) {
      $this->query .= ' ' . $name . ' MEDIUMTEXT ';
      return $this;
    }

    // Auto-incrementing UNSIGNED SMALLINT (primary key) equivalent column.
    function smallIncrements( $name ) {
      $this->query .= ' SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY ';
      return $this;
    }

    // SMALLINT equivalent column.
    function smallInteger( $name ) {
      $this->query .= ' ' . $name . ' SMALLINT ';
      return $this;
    }

    // VARCHAR equivalent column with a optional length.
    function string( $name, $max = 250 ) {
      $this->query .= ' ' . $name . ' VARCHAR('.$max.') ';
      return $this;
    }

    // TEXT equivalent column.
    function text( $name ) {
      $this->query .= ' ' . $name . ' TEXT ';
      return $this;
    }

    // TIME equivalent column.
    function time( $name ) {
      $this->query .= ' ' . $name . ' TIME ';
      return $this;
    }

    // TIMESTAMP equivalent column.
    function timestamp( $name ) {
      $this->query .= ' ' . $name . ' TIMESTAMP ';
      return $this;
    }

    // Auto-incrementing UNSIGNED TINYINT (primary key) equivalent column.
    function smallIncrements( $name ) {
      $this->query .= ' TINYINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY ';
      return $this;
    }

    // TINYINT equivalent column.
    function tinyInteger( $name ) {
      $this->query .= ' ' . $name . ' TINYINT ';
      return $this;
    }

    // UUID equivalent column.
    function uuid( $name ) {
      $this->query .= ' ' . $name . ' UUID ';
      return $this;
    }


  }