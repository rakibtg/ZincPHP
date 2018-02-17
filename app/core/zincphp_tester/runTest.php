<?php

  require_once __DIR__ . '/ZincTester.php';
  require_once __DIR__ . '/BlockTester.php';

  $tester = new ZincTester();

  // // Test test started.
  // require_once '/home/rakibtg/Projects/ZincPHP/blocks/test-make-request/tests/put.test-make-request.test.php';
  // $blockTester = new Puttestmakerequest();
  // $blockTester->makeTest();
  // $blockTester->runTest();
  // Test test end.
  // exit();

  $testables = $tester->getTestDirectories();
  if ( $tester->blocksCount > 0 ) {
    echo '> ' . \ZincPHP\CLI\Helper\success( $tester->blocksCount . " blocks and " . $tester->testFilesCount . " files to test." );
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