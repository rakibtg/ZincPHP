<?php

  /*
    Collection of methods that handles everything
    related to sending requests.
  */

  trait InputTraits {

    public static function input ( $fieldName = false ) {
      return ( new ZincPHPInput )->input( $fieldName );
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
