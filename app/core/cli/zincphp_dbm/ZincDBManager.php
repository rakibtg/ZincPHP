<?php

  namespace ZincPHP\Database\Manager;

  // Autoload files using Composer autoload
  require_once __DIR__ . '/../../../../vendor/autoload.php';

  require_once __DIR__ . '/MigrationTrait.php';
  require_once __DIR__ . '/SeedsTrait.php';
  require_once __DIR__ . '/../../zinc/Zinc.php';
  require_once __DIR__ . '/../../app/App.php';

  class ZincDBManager {

    use \MigrationTrait, \SeedsTrait;

  }
