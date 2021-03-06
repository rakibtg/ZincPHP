<?php

  trait HelperTraits {

    /**
     * Get all the environments data.
     *
     * @return array The environment settings as a PHP data object.
     */
    public static function environment() {
      return \ZincPHP\environment\ZincEnvironment::getInstance()
        ->readEnvFile();
    }

    /**
     * Shortcut to print_r method.
     *
     * @param array $arr
     * @return void
     */
    public static function pr( $arr = [] ) {
      echo '<pre>';
      print_r( $arr );
      echo '</pre>';
      exit();
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
      if ( self::requestType() === $method ) {
          if ( $key === false ) return self::restRequests();
          $_data = self::restRequests();
          if ( isset( $_data[ $key ] ) ) return self::string( $_data[ $key ] )->trim();
      }
      return '';
    }

    /**
     * Generate unique random string of a length.
     *
     * @param  integer $length Total number of charecters need to be returned.
     * @return string  The random string.
     */
    public static function randomString( $length = 10 ) {
      $keySpace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $str = '';
      if( function_exists( 'mb_strlen' ) ) {
        $max = mb_strlen( $keySpace, '8bit' ) - 1;
      } else {
        $max = strlen( $keySpace );
      }
      for ( $i = 0; $i < $length; ++$i ) {
        if ( function_exists( 'random_int' ) ) {
          $str .= $keySpace[ random_int( 0, $max ) ];
        } else {
          $str .= $keySpace[ mt_rand( 0, $max ) ];
        }
      }
      return $str;
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
        else return $url . '' . $uri;
    }

    /**
     * The full path of the current route.
     *
     * @return string
     */
    public static function current_url() {
        return self::url() . $_SERVER["REQUEST_URI"];
    }

    /**
     * Generates slug of a string. Supports any languages.
     * Try to avoid + as the separator as this would break the slug.
     *
     * @param   string $url         Plain text
     * @param   string $separator   The separator of the slug
     * @return  string
     */
    public static function slug( $url = '', $separator = '_' ) {
        $url = trim( $url );
        foreach( [
            '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '-', '+', '=',
            '[', '{', ']', '}', ';', ':', '"', "'", ',', '>', '.', '<', '/', '?', '\\', '|'
        ] as $del ) {
            $url = str_replace( $del, '', $url );
        }
        $url = str_replace( ' ', $separator, trim( $url ) );
        return preg_replace( '/'.$separator.'+/', $separator, $url );
    }

    /**
     * Generates slug of a string, keeps only the English characters.
     *
     * @param   string    $url         Plain text
     * @param   string    $separator   The separator of the slug
     * @return  boolean   $fallback    The fallback is idea because if the slug is empty then
     *                                 instead of empty it would return a unique random string as the slug.
     */
    public static function en_slug( $url = '', $separator = ' ', $fallback = false ) {
      $url = trim( $url );
      $url = preg_replace('/[^a-zA-Z0-9\s]/', '', $url);
      $url = preg_replace('!\s+!', ' ', $url);
      $url = str_replace( ' ', $separator, $url );
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
    public static function sortBy( $field, &$objectSortable, $direction = 'asc' ) {
      usort( $objectSortable, create_function( '$a, $b', '
        $a = $a["' . $field . '"];
        $b = $b["' . $field . '"];
        if ($a == $b) { return 0; }
        return ($a ' . ( $direction == 'desc' ? '>' : '<' ) .' $b) ? -1 : 1;
      ') );
      return true;
    }

    /**
     * Get the root directory of the app.
     *
     * @param   string $path Custom path to be added from the root directory.
     * @return  string
     */
    public static function dir( $path = false ) {
      $returnable = preg_replace(
        '/'. preg_quote( 
          "app"
          . DIRECTORY_SEPARATOR
          . "core"
          . DIRECTORY_SEPARATOR
          . "intellect"
          . DIRECTORY_SEPARATOR
          . "intellect_traits"
          . DIRECTORY_SEPARATOR, 
        '/' ) . '$/',
        '',
        __DIR__ . DIRECTORY_SEPARATOR
      );
      if ( $path !== false ) return $returnable . $path;
      return $returnable;
    }

    /**
     * Custom error exception handler.
     * 
     */
    public static function exception( $e ) {
      if( gettype($e) === 'string' ) {
        $data = [ 'message' => $e ];
      } else {
        $data = [
          'message' => $e->getMessage(),
          'file'    => $e->getFile(),
          'line'    => $e->getLine(),
          'code'    => $e->getCode(),
          'trace'   => $e->getTrace()
        ];
      }
      self::response($data)
        ->error()
        ->pretty()
        ->exit()
        ->send();
    }

    /**
     * Method to generate the response of a request.
     * 
     */
    public static function response($data = []) {
      return new ZincPHP\Response\ZincResponse($data);
    }

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

    /**
     * Get input data from the available request method.
     *
     * @param   string $field The filed name, if not given then return all data of the request.
     * @return  string Returns null if the key is not found by default.
     */
    public static function input( $field = false ) {
      $_input = \ZincPHP\Input\ZincInput::getInstance()
        ->provider();
      if( $field ) return $_input->input( $field );
      else return $_input;
    }

    /**
     * A string manipulation library with multi-byte support.
     * 
     * @param   string $str The string need to be manipulated.
     * @return  string 
     */
    public static function string( $str ) {
      return \ZincPHP\String\ZincString::create( $str );
    }

  }
