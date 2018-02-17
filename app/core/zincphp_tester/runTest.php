<?php

  require_once __DIR__ . '/ZincTester.php';
  $tester = new ZincTester();
  $testables = $tester->getTestDirectories();
  if ( $tester->blocksCount > 0 ) {
    echo \ZincPHP\CLI\Helper\success( $tester->blocksCount . " blocks and " . ( $tester->testFilesCount + 1 ) . " files to test." );
    \ZincPHP\CLI\Helper\nl();
    echo $tester->run();
    // print_r( $testables );
    echo "\n";
  } else {
    echo \ZincPHP\CLI\Helper\danger( "No tests found!" );
    \ZincPHP\CLI\Helper\nl();
  }

  // Exit the CLI execution.
  exit();