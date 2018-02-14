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
        App::response_error( 'Environment document was not found! Run \'php zinc env:new\' command to create a new environment document.' );
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
      if ( App::requestType() === $method ) {
          if ( $key === false ) return App::restRequests();
          $_data = App::restRequests();
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

    /**
     * Returns the domain and with URI if provided.
     *
     * @param   string  $uri    The URI to be append with the domain.
     * @return  string
     */
    public static function url( $uri = '/' ) {
        if( isset( $_SERVER[ "HTTPS" ] ) && ! empty( $_SERVER[ "HTTPS" ] ) && ( $_SERVER[ "HTTPS" ] != 'on' ) ) {
            $url = 'https://'.$_SERVER["SERVER_NAME"]; //https url
        }  else {
            $url =  'http://'.$_SERVER["SERVER_NAME"]; //http url
        }
        if(( $_SERVER["SERVER_PORT"] != 80 )) $url .= ':' . $_SERVER["SERVER_PORT"];
        if( trim( $uri ) == '/' ) return $url;
        else return $url . '/?route=' . $uri;
    }

    /**
     * The full path of the current route.
     *
     * @return string
     */
    public static function current_url() {
        return App::url() . $_SERVER["REQUEST_URI"];
    }

    /**
     * Generates slug of a string. Supports any languages.
     * Try to avoid + as the seperator as this would break the slug.
     *
     * @param   string $url         Plain text
     * @param   string $seperator   The seperator of the slug
     * @return  string
     */
    public static function slug( $url = '', $seperator = '_' ) {
        $url = trim( $url );
        foreach( [
            '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '-', '+', '=',
            '[', '{', ']', '}', ';', ':', '"', "'", ',', '>', '.', '<', '/', '?', '\\', '|'
        ] as $del ) {
            $url = str_replace( $del, '', $url );
        }
        $url = str_replace( ' ', $seperator, trim( $url ) );
        return preg_replace( '/'.$seperator.'+/', $seperator, $url );
    }

    /**
     * Generates slug of a string, keep only english charecters.
     *
     * @param   string    $url         Plain text
     * @param   string    $seperator   The seperator of the slug
     * @return  boolean   $fallback    The fallback is idea because if the slug is empty then
     *                                 instead of empty it would return a unique random string as the slug.
     */
    public static function en_slug( $url = '', $seperator = ' ', $fallback = false ) {
      $url = trim( $url );
      $url = preg_replace('/[^a-zA-Z0-9\s]/', '', $url);
      $url = preg_replace('!\s+!', ' ', $url);
      $url = str_replace( ' ', $seperator, $url );
      if( $fallback ) $url .= mt_rand();
      return $url;
    }

    /**
     * Sort a associative array ascending or descending by its key(index).
     *
     * @param   string    $field            Name of the key.
     * @param   array     $objectSortable   Associative array to sort.
     * @param   string    $direction        Sort by asc or desc. Default is asc order.
     * 
     * @return  boolean   On successful sort it will return a boolean true.
     */
    function sortBy( $field, &$objectSortable, $direction = 'asc' ) {
      usort( $objectSortable, create_function( '$a, $b', '
        $a = $a["' . $field . '"];
        $b = $b["' . $field . '"];
        if ($a == $b) { return 0; }
        return ($a ' . ( $direction == 'desc' ? '>' : '<' ) .' $b) ? -1 : 1;
      ') );
      return true;
    }

  }