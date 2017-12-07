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
     * Get input data from GET requests.
     *
     * @param string $key Input field key name.
     * @return string
     */
    function get( $key ) {
        if( ! isset( $_GET[ $key ] ) ) return '';
        return strTrim( $_GET[ $key ] );
    }

    /**
     * Get input data form POST requests.
     *
     * @param string $key Input field key name.
     * @return string
     */
    function post( $key ) {
        if( ! isset( $_POST[ $key ] ) ) return '';
        return strTrim( $_POST[ $key ] );
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
    function return_error( $msg = false, $status = 404 ) {
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
