<?php

  trait HelperTraits {

    /**
     * Get all the environments data.
     * 
     * @return array App settings; JSON document as array.
     */
    public static function environment() {
      // Import and set environment variables from environment document.
      if( ! file_exists( '../app/environment.json' ) ) {
        \zp\response_error( 'Environment document was not found! Run \'php zinc env:new\' command to create a new environment document.' );
        exit();
      }
      // Set environment settings
      return json_decode( file_get_contents( '../app/environment.json' ) );
    }

    /**
     * Shortcut to print_r method.
     *
     * @param array $arr
     * @return void
     */
    public static function pr( $arr = [] ) {
      print_r( $arr );
    }

    /**
     * Checks if a variable exists, else
     * returns null.
     *
     * @param    any      $str Any variable.
     * @return   string
     */
    public static function strTrim( $str ) {
      if( ! isset( $str ) ) return '';
      return trim( $str );
    }

    /**
     * Returns the request type.
     *
     * @return string Request type.
     */
    public static function requestType() {
      return trim( strtolower( $_SERVER[ 'REQUEST_METHOD' ] ) );
    }

    /**
     * Returns requests data, used except POST and GET method.
     *
     * @return array Available data from request.
     */
    public static function requestData() {
      parse_str( file_get_contents( "php://input" ), $reqData );
      return ( array ) $reqData;
    }

    /**
     * Get data from specific method.
     *
     * @param   string  $method  The method type name.
     * @param   string  $key     Expected key name from the request data.
     * @return  any     ...      Available data from request.
     */
    public static function requestFormula( $method = 'put', $key = false ) {
      if ( \zp\requestType() === $method ) {
          if ( $key === false ) return \zp\restRequests();
          $_data = \zp\restRequests();
          if ( isset( $_data[ $key ] ) ) return strTrim( $_data[ $key ] );
      }
      return '';
    }

    /**
     * Fallback to random_bytes() function for PHP 5+
     * 
     * @param  integer $length Total number of charecters need to be returned.
     * @return string  The random string.
     */
    public static function randomString( $length = 10 ) {
      if ( function_exists( 'random_bytes' ) ) {
        return random_bytes( $length );
      } else {
        $keyspace = '0123456789abcdefg.hijklmnopqrstuvwxyzA-BCDEFGHIJK_LMNOPQRSTU#VWXYZ';
        $str = '';
        if( function_exists( 'mb_strlen' ) ) {
          $max = mb_strlen( $keyspace, '8bit' ) - 1;
        } else {
          $max = strlen( $keyspace );
        }        
        for ( $i = 0; $i < $length; ++$i ) {
          if ( function_exists( 'random_int' ) ) {
            $str .= $keyspace[ random_int( 0, $max ) ];
          } else {
            $str .= $keyspace[ mt_rand( 0, $max ) ];
          }
        }
        return $str;
      }
    }

  }