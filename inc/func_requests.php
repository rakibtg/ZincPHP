<?php

    function strTrim( $str ) {
        if( ! isset( $str ) ) return '';
        return trim( $str );
    }

    function _get( $key ) {
        if( ! isset( $_GET[ $key ] ) ) return '';
        return strTrim( $_GET[ $key ] );
    }

    function _post( $key ) {
        if( ! isset( $_POST[ $key ] ) ) return '';
        return strTrim( $_POST[ $key ] );
    }