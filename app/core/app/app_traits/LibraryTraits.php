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
      $libpath = App::dir( 'libraries' );


      // Import each library.
      foreach ( $libraryName as $lib ) {

        // Location of current library.
        $liblocation = $libpath . '/' . $lib . '/' . basename( trim( $lib, '/' ) ) . '.php';

        // Check if library exists.
        if ( ! file_exists( $liblocation ) ) App::responseError(
          'Error: Library not found. Looking for "'.$liblocation.'"',
          500
        );

        // Import this library.
        require_once $liblocation;

      }
    }

  }
