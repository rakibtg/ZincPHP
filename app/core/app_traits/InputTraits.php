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
      if ( $method === 'get' ) return $_GET;

      // Encode data based on content type
      if ( $contentType === 'application/x-www-form-urlencoded' ) {
        if ( $method === 'post' ) return $_POST;
        else return json_decode( file_get_contents( "php://input" ), true );
      } else {
        return json_decode( file_get_contents( "php://input" ), true );
      }

      return [];

    }

    /**
     * Get input data from GET requests.
     *
     * @param string $key Input field key name.
     * @return string
     */
    public static function get( $key = false ) {
      if( $key === false ) {
        return $_GET;
      } else {
          if ( isset( $_GET[ $key ] ) ) {
            return App::strTrim( $_GET[ $key ] );
          } else {
            return '';
          }
      }
    }

    /**
     * Get input data form POST requests.
     *
     * @param string $key Input field key name.
     * @return string
     */
    public static function post( $key = false ) {
      if( $key === false ) {
        return $_POST;
      } else {
        if ( isset( $_POST[ $key ] ) ) {
          return App::strTrim( $_POST[ $key ] );
        } else {
          return '';
        }
      }
    }

    /**
     * Get input data form PUT requests.
     *
     * @param string $key Input field key name.
     * @return string
     */
    public static function put( $key ) {
      if( App::requestType() === 'put' ) {
        if( ! isset( $_POST[ $key ] ) ) return '';
        return App::strTrim( $_POST[ $key ] );
      }
      return '';
    }

    /**
     * Get input data form DELETE requests.
     *
     * @param string $key Input field key name.
     * @return string
     */
    public static function delete( $key ) {
      if( App::requestType() === 'delete' ) {
        if( ! isset( $_POST[ $key ] ) ) return '';
        return App::strTrim( $_POST[ $key ] );
      }
      return '';
    }

    /**
     * Get input data form COPY requests.
     *
     * @param string $key Input field key name.
     * @return string
     */
    public static function copy( $key ) {
      if( App::requestType() === 'copy' ) {
        if( ! isset( $_POST[ $key ] ) ) return '';
        return App::strTrim( $_POST[ $key ] );
      }
      return '';
    }

    /**
     * Get input data form OPTIONS requests.
     *
     * @param string $key Input field key name.
     * @return string
     */
    public static function options( $key ) {
      if( App::requestType() === 'options' ) {
        if( ! isset( $_POST[ $key ] ) ) return '';
        return App::strTrim( $_POST[ $key ] );
      }
      return '';
    }

    /**
     * Get input data form PROPFIND requests.
     *
     * @param string $key Input field key name.
     * @return string
     */
    public static function propfind( $key ) {
      if( App::requestType() === 'propfind' ) {
        if( ! isset( $_POST[ $key ] ) ) return '';
        return App::strTrim( $_POST[ $key ] );
      }
      return '';
    }

    /**
     * Get input data form PATCH requests.
     *
     * @param string $key Input field key name.
     * @return string
     */
    public static function patch( $key ) {
      if( App::requestType() === 'patch' ) {
        if( ! isset( $_POST[ $key ] ) ) return '';
        return App::strTrim( $_POST[ $key ] );
      }
      return '';
    }
  }
