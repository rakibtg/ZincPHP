<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require "../inc/core/Zink.php";
    $zink = new Zink();

    // Setting JSON type globally.
    header('Content-Type: application/json; charset=utf-8');

    require "../inc/func_return_404.php";
    require "../inc/func_requests.php";

    // Simple routing.
    if( isset( $_GET[ 'route' ] ) ) {
        $component = trim( $_GET[ 'route' ] );
    } else {
        return_404();
    }

    // Check if component exist.
    $segments = '/'; 
    // For security purposes recasting the url splitted by segments.
    foreach( explode( '/', $component ) as $uri ) {
        $segments = $segments . $uri . '/';
    }
    $component = '../components'.rtrim( $segments, '/' ).'.php';
    if( file_exists( $component ) ) {
        require $component;
    } else {
        return_404( 'Controller not found.' );
    }