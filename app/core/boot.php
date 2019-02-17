<?php

  // Autoload files using Composer autoload
  $autoLoader = __DIR__ . '/../../vendor/autoload.php';
  if ( file_exists( $autoLoader ) ) {
    require_once $autoLoader;
  }
  require_once __DIR__ . '/zinc/Zinc.php';

  /**
   * Instantiating Zinc core class.
   * This will boot the framework, and will
   * add other core libraries like validator, jwt,
   * database query builder etc with each block to be served.
   * Dynamic routing will be handled from this class.
   *
   * @return void
   */

  new \ZincPHP\Zinc\Zinc();