<?php

    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(-1);

    header("Access-Control-Allow-Origin: *");

    // Setting JSON type globally.
    header('Content-Type: application/json; charset=utf-8');

    // Includes
    require "./inc/DB.php";
    require "./inc/func_return_404.php";
    require "./inc/func_requests.php";
    // Instanciate database class
    $db = DB::getInstance(); // $db should be available in all components.
    
    // Simple routing.
    if( isset( $_GET[ 'controller' ] ) ) {
        $component = trim( $_GET[ 'controller' ] );
    } else {
        return_404();
    }

    // Check if component exist.
    $segments = '/';
    foreach( explode( '.', $component ) as $uri ) {
        $segments = $segments . $uri . '/';
    }
    $component = './components'.rtrim( $segments, '/' ).'.php';
    if( file_exists( $component ) ) {
        require $component;
    } else {
        return_404( 'Controller not found.' );
    }