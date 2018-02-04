<?php

    namespace zp;

    /**
     * Shortcut to print_r method.
     *
     * @param array $arr
     *
     * @return void
     */
    function pr( $arr = [] ) {
        print_r( $arr );
    }

    /**
     * Checks if a variable exists, else
     * returns null.
     *
     * @param    any      $str Any variable.
     * @return   string
     */
    function strTrim( $str ) {
        if( ! isset( $str ) ) return '';
        return trim( $str );
    }

    /**
     * Returns the request type.
     * 
     * @return string Request type.
     * 
     */
    function requestType() {
        return trim( strtolower( $_SERVER[ 'REQUEST_METHOD' ] ) );
    }

    /**
     * Get input data from GET requests.
     *
     * @param string $key Input field key name.
     * @return string
     */
    function get( $key = false ) {
        if( $key === false ) {
            return $_GET;
        } else {
            if ( isset( $_GET[ $key ] ) ) {
                return strTrim( $_GET[ $key ] );
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
    function post( $key = false ) {
        if( $key === false ) {
            return $_POST;
        } else {
            if ( isset( $_POST[ $key ] ) ) {
                return strTrim( $_POST[ $key ] );
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
    function put( $key ) {
        if( \zp\requestType() === 'put' ) {
            if( ! isset( $_POST[ $key ] ) ) return '';
            return strTrim( $_POST[ $key ] );
        }
        return '';
    }


    /**
     * Get input data form DELETE requests.
     *
     * @param string $key Input field key name.
     * @return string
     */
    function delete( $key ) {
        if( \zp\requestType() === 'delete' ) {
            if( ! isset( $_POST[ $key ] ) ) return '';
            return strTrim( $_POST[ $key ] );
        }
        return '';
    }


    /**
     * Get input data form COPY requests.
     *
     * @param string $key Input field key name.
     * @return string
     */
    function copy( $key ) {
        if( \zp\requestType() === 'copy' ) {
            if( ! isset( $_POST[ $key ] ) ) return '';
            return strTrim( $_POST[ $key ] );
        }
        return '';
    }


    /**
     * Get input data form OPTIONS requests.
     *
     * @param string $key Input field key name.
     * @return string
     */
    function options( $key ) {
        if( \zp\requestType() === 'options' ) {
            if( ! isset( $_POST[ $key ] ) ) return '';
            return strTrim( $_POST[ $key ] );
        }
        return '';
    }    


    /**
     * Get input data form PROPFIND requests.
     *
     * @param string $key Input field key name.
     * @return string
     */
    function propfind( $key ) {
        if( \zp\requestType() === 'propfind' ) {
            if( ! isset( $_POST[ $key ] ) ) return '';
            return strTrim( $_POST[ $key ] );
        }
        return '';
    }   
    

    /**
     * Get input data form PATCH requests.
     *
     * @param string $key Input field key name.
     * @return string
     */
    function patch( $key ) {
        if( \zp\requestType() === 'patch' ) {
            if( ! isset( $_POST[ $key ] ) ) return '';
            return strTrim( $_POST[ $key ] );
        }
        return '';
    }   


    /**
     * Converts data to json then print it.
     *
     * @param array|object|string   $data           Data to output
     * @param integer               $responseStatus Set the response status code
     * @param boolean               $prettyPrint    Pretty prints the output JSON
     * @return void
     */
    function response( $data = [], $responseStatus = 200, $prettyPrint = false ) {

        // Setting the reponse code of the output.
        http_response_code( $responseStatus );

        if( empty( $data ) ) {
            echo json_encode( [] );
        } else if ( is_array( $data ) ) {
            if( $prettyPrint ) echo json_encode( $data, JSON_PRETTY_PRINT );
            else echo json_encode( $data );
        } else {
            echo json_encode( [ $data ] );
        }
        exit();
    }

    /**
     * Returns error with custom status response.
     * If a error message was not provided then the default
     * error message will be printed.
     *
     * @param   string    $msg        Custom error message
     * @param   integer   $status     HTTP status code, defualt is 404 (Not found)
     * @return  void
     */
    function response_error( $msg = false, $status = 404 ) {
        http_response_code( $status );
        if( ! $msg ) $msg = 'Unexpected error occured';
        echo json_encode( [
            'status' => $msg,
        ] );
        exit();
    }

    /**
     * Returns the domain and with URI if provided.
     *
     * @param   string  $uri    The URI to be append with the domain.
     * @return  string
     */
    function url( $uri = '/' ) {
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
    function current_url() {
        return url() . $_SERVER["REQUEST_URI"];
    }

    /**
     * Generates slug of a string. Supports any languages.
     * Try to avoid + as the seperator as this would break the slug.
     *
     * @param   string $url         Plain text
     * @param   string $seperator   The seperator of the slug
     * @return  string
     */
    function slug( $url = '', $seperator = '_' ) {
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
    function en_slug( $url = '', $seperator = ' ', $fallback = false ) {
      $url = trim( $url );
      $url = preg_replace('/[^a-zA-Z0-9\s]/', '', $url);
      $url = preg_replace('!\s+!', ' ', $url);
      $url = str_replace( ' ', $seperator, $url );
      if( $fallback ) $url .= mt_rand();
      return $url;
    }
