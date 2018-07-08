<?php

  /*
    Collection of methods that handles everything
    related to sending requests.
  */

  trait InputTraits {

    /**
     * Get input data from the available request method.
     *
     * @param   string $fieldName The filed name, if not given then return all data of the request.
     * @return  string Returns null if the key is not found by default.
     */
    public static function input ( $fieldName = false ) {

      $method = App::requestType();
      $data   = '';

      // Detecting the content type of the request.
      if ( ! isset( $_SERVER[ "CONTENT_TYPE" ] ) ) {

        // No content type was found. Setting up default.
        $contentType = 'text/plain';

      } else {

        $contentType = explode( ';', $_SERVER[ "CONTENT_TYPE" ] );
        if ( isset( $contentType[ 0 ] ) ) {

          if ( ! empty( $contentType[ 0 ] ) ) $contentType = trim( $contentType[ 0 ] );
          else $contentType = 'text/plain';

        } else $contentType = 'text/plain';

      }

      // We dont need a check if GET method
      if ( $method === 'get' ) {
        $data = $_GET;
      } else {
        // Encode data based on content type
        if ( $contentType === 'application/x-www-form-urlencoded' ) {
          if ( $method === 'post' ) $data = $_POST;
          else $data = json_decode( file_get_contents( "php://input" ), true );
        } else {
          $data = json_decode( file_get_contents( "php://input" ), true );
        }
      }

      // Get data by field name.
      if ( $fieldName !== false ) {
        return isset( $data[ $fieldName ] ) ? $data[ $fieldName ] : '';
      } else {
        return $data;
      }

    }
    
  }
