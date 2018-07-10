<?php

  // Autoload files using Composer autoload
  if ( file_exists( __DIR__ . '/../../vendor/autoload.php' ) ) require_once __DIR__ . '/../../vendor/autoload.php';

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
  $zinc = new Zinc();
