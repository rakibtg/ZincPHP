<?php

  trait LibraryTraits {

    /**
     * Method to import one or more than one user defined libraries into a block.
     *
     * @param   array $libraryName List of libraries to import.
     * @return  void
     */
    public static function import ( $libraryName = [] ) {

      if ( empty( $libraryName ) ) return false;

      // Cast library name to an array.
      if ( ! is_array( $libraryName ) ) $libraryName = ( array ) $libraryName;

      // Cache library path.
      $libPath = self::dir( 'libraries' );

      // Import each library.
      foreach ( $libraryName as $lib ) {

        // Location of current library.
        $libLocation = $libPath . '/' . $lib . '/' . basename( trim( $lib, '/' ) ) . '.php';

        // Check if library exists.
        if ( ! file_exists( $libLocation ) ) throw new Exception( 'Error: Library not found. Looking for "'.$libLocation.'"' );

        // Import this library.
        require_once $libLocation;

      }
    }

  }
