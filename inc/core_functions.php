<?php

    namespace zp;

    function pr( $arr = [] ) {
        print_r( $arr );
    }

    function strTrim( $str ) {
        if( ! isset( $str ) ) return '';
        return trim( $str );
    }

    function get( $key ) {
        if( ! isset( $_GET[ $key ] ) ) return '';
        return strTrim( $_GET[ $key ] );
    }

    function post( $key ) {
        if( ! isset( $_POST[ $key ] ) ) return '';
        return strTrim( $_POST[ $key ] );
    }

    function output( $data = [], $resCode = 200, $prettyPrint = false ) {

        // Setting the reponse code of the output.
        http_response_code( $resCode );

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

    function return_error( $msg = false, $status = 404 ) {
        http_response_code( $status );
        if( ! $msg ) $msg = 'Unexpected error occured';
        echo json_encode( [
            'status' => $msg,
        ] );
        exit();
    }

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


    function current_url() {
        return url() . $_SERVER["REQUEST_URI"];
    }

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