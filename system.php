<?php
    require_once "../inc/core/Zinc.php";
    error_reporting( E_ALL );
    ini_set( 'display_errors', 1 );

    // Setting JSON type globally.
    header( 'Content-Type: application/json; charset=utf-8' );
    
    /**
     * Instantiating Zinc core class.
     * This will boot the framework, and will
     * add other core libraries like validator, jwt, 
     * database query builder etc with each block to be served.
     * Dynamic routing will be handled from this class.
     * 
     * @param object $env The environment variables of this app.
     * @return void
     */
    $zinc = new Zinc();