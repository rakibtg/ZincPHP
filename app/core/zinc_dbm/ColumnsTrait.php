<?php
  
  trait ColumnsTrait {

    // Auto-incrementing UNSIGNED BIGINT (primary key) equivalent column.
    function bigIncrements( $name ) {
      $this->queryBody .= ', '.$name.' BIGINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY ';
      return $this;
    }

    // BIGINT equivalent column.
    function bigInteger( $name ) {
      $this->queryBody .= ', ' . $name . ' BIGINT ';
      return $this;
    }

    // BLOB equivalent column.
    function binary( $name ) {
      $this->queryBody .= ', ' . $name . ' BLOB ';
      return $this;
    }

    // BOOLEAN equivalent column.
    function boolean( $name ) {
      $this->queryBody .= ', ' . $name . ' BOOLEAN ';
      return $this;
    }

    // CHAR equivalent column with an optional length.
    function char( $name, $max = 250 ) {
      $this->queryBody .= ', ' . $name . ' CHAR(' . $max . ') ';
      return $this;
    }

    // DATE equivalent column.
    function date( $name ) {
      $this->queryBody .= ', ' . $name . ' DATE ';
      return $this;
    }

    // DATETIME equivalent column.
    function dateTime( $name ) {
      $this->queryBody .= ', ' . $name . ' DATETIME ';
      return $this;
    }

    // DECIMAL equivalent column with a precision (total digits) and scale (decimal digits).
    function decimal( $name, $precision = 8, $scale = 2 ) {
      $this->queryBody .= ', ' . $name . ' DECIMAL('.$precision.', '.$scale.') ';
      return $this;
    }

    // DOUBLE equivalent column with a precision (total digits) and scale (decimal digits).
    function double( $name, $precision = 8, $scale = 2 ) {
      $this->queryBody .= ', ' . $name . ' DOUBLE('.$precision.', '.$scale.') ';
      return $this;
    }

    // ENUM equivalent column.
    function enum( $name, $list = [] ) {
      $_items = '';
      return $this;
      foreach( $list as $i ) {
        $_items .= "'".$i."',";
      }
      $this->queryBody .= ', ' . $name . ' ENUM( '.rtrim($_items, ',').' ) ';
    }

    // FLOAT equivalent column with a precision (total digits) and scale (decimal digits).
    function float( $name, $precision = 8, $scale = 2 ) {
      $this->queryBody .= ', ' . $FLOAT . ' FLOAT('.$precision.', '.$scale.') ';
      return $this;
    }

    // GEOMETRY equivalent column.
    function geometry( $name ) {
      $this->queryBody .= ', ' . $name . ' GEOMETRY ';
      return $this;
    }

    // GEOMETRYCOLLECTION equivalent column.
    function geometryCollection( $name ) {
      $this->queryBody .= ', ' . $name . ' GEOMETRYCOLLECTION ';
      return $this;
    }

    // Auto-incrementing UNSIGNED INTEGER (primary key) equivalent column.
    function increments( $name ) {
      $this->queryBody .= ', ' . $name . ' INTEGER UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY ';
      return $this;
    }

    // INTEGER equivalent column.
    function integer( $name ) {
      $this->queryBody .= ', ' . $name . ' INTEGER ';
      return $this;
    }

    // JSON equivalent column.
    function json( $name ) {
      $this->queryBody .= ', ' . $name . ' JSON ';
      return $this;
    }

    // JSONB equivalent column.
    function jsonb( $name ) {
      $this->queryBody .= ', ' . $name . ' JSONB ';
      return $this;
    }


    // UNIQUE equivalent column.
    function unique() {
      $this->queryBody .= ' UNIQUE ';
      return $this;
    }

    // LINESTRING equivalent column.
    function lineString( $name ) {
      $this->queryBody .= ', ' . $name . ' LINESTRING ';
      return $this;
    }
    
    // LONGTEXT equivalent column.
    function longText( $name ) {
      $this->queryBody .= ', ' . $name . ' LONGTEXT ';
      return $this;
    }

    // Auto-incrementing UNSIGNED MEDIUMINT (primary key) equivalent colum.
    function mediumIncrements( $name ) {
      $this->queryBody .= ', '.$name.' MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY ';
      return $this;
    }
        
    // MEDIUMINT equivalent column.
    function mediumInteger( $name ) {
      $this->queryBody .= ', ' . $name . ' MEDIUMINT ';
      return $this;
    }
     
    // MEDIUMTEXT equivalent column.
    function mediumText( $name ) {
      $this->queryBody .= ', ' . $name . ' MEDIUMTEXT ';
      return $this;
    }

    // Auto-incrementing UNSIGNED SMALLINT (primary key) equivalent column.
    function smallIncrements( $name ) {
      $this->queryBody .= ', '.$name.' SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY ';
      return $this;
    }

    // SMALLINT equivalent column.
    function smallInteger( $name ) {
      $this->queryBody .= ', ' . $name . ' SMALLINT ';
      return $this;
    }

    // VARCHAR equivalent column with a optional length.
    function string( $name, $max = 250 ) {
      $this->queryBody .= ', ' . $name . ' VARCHAR('.$max.') ';
      return $this;
    }

    // TEXT equivalent column.
    function text( $name ) {
      $this->queryBody .= ', ' . $name . ' TEXT ';
      return $this;
    }

    // TIME equivalent column.
    function time( $name ) {
      $this->queryBody .= ', ' . $name . ' TIME ';
      return $this;
    }

    // TIMESTAMP equivalent column.
    function timestamp( $name ) {
      $this->queryBody .= ', ' . $name . ' TIMESTAMP ';
      return $this;
    }

    // Auto-incrementing UNSIGNED TINYINT (primary key) equivalent column.
    function tinyIncrements( $name ) {
      $this->queryBody .= ', '.$name.'TINYINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY ';
      return $this;
    }

    // TINYINT equivalent column.
    function tinyInteger( $name ) {
      $this->queryBody .= ', ' . $name . ' TINYINT ';
      return $this;
    }

    // UUID equivalent column.
    function uuid( $name ) {
      $this->queryBody .= ', ' . $name . ' UUID ';
      return $this;
    }

    /**
     * Renames a column.
     * 
     * @param   string   $oldName    Existing name of the column.
     * @param   string   $newName    New name for the column.
     * @param   string   $dataType   Datatype for the column.
     * @param   integer  $dataLimit  Max limit of the data, if not provided then it would set to 200 by default.
     * @return  object               Current object.
     */
    function renameColumn( $oldName, $newName, $dataType, $dataLimit = false ) {
      $_rawQuery      = "ALTER TABLE ".$this->tableName." CHANGE `".$oldName."` `".$newName."` ";
      if( $dataLimit ) {
        $_rawQuery .= $dataType . "(" . $dataLimit . ");";
      } else {
        $_rawQuery .= $dataType . "(200);";
      }
      $this->rawQuery = $_rawQuery;
      return $this;
    }


  }