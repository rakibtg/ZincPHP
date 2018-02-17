<?php

  require_once __DIR__ . '/ZincTester.php';
  $tester = new ZincTester();
  $testables = $tester->getTestDirectories();
  echo "\n";
  echo $tester->blocksCount . " blocks and " . ( $tester->testFilesCount + 1 ) . " files to test.";
  echo "\n";
  print_r( $testables );

  echo "\n";
  // Exit the CLI execution.
  exit();