<?php

  require_once __DIR__ . '/ZincTester.php';
  require_once __DIR__ . '/BlockTester.php';

  // Run the test.
  ( new ZincTester )->run( $argv );

  // Exit the CLI execution.
  exit();