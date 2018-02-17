<?php

  class ZincTester {
    public $blocksCount;
    public $testFilesCount;
    public $testables;

    function __construct() {
      $this->blocksCount    = 0;
      $this->testFilesCount = 0;
      $this->testables      = [];
    }

    function getTestDirectories( $dir = false, &$results = [] ) {
      if ( $dir === false ) $dir = './blocks';
      $files = scandir( $dir );
      foreach( $files as $key => $value ){
        $path = realpath( $dir . DIRECTORY_SEPARATOR . $value );
        if( is_dir( $path ) ) {
          if( $value != "." && $value != ".." ) {
            $this->getTestDirectories( $path, $results );
            $_testDir = explode( DIRECTORY_SEPARATOR, $path );
            if ( $_testDir[ count( $_testDir ) - 1 ] === 'tests' ) {
              $testable[ 'block' ] = $_testDir[ count( $_testDir ) - 2 ];
              $testable[ 'path'  ] = $path;
              $testable[ 'files' ] = [];
              $testableFiles = scandir( $path );
              foreach( $testableFiles as $tf ) {
                if( $tf != '.' && $tf != '..' && substr( trim( $tf ), -9 ) == '.test.php' ) {
                  $testable[ 'files' ][] = $tf;
                }
              }
              if ( count ( $testable[ 'files' ] ) > 0 ) {
                $this->testFilesCount += 1;
                $results[] = $testable;
              }
            }
          }
        }
      }
      $this->blocksCount = count( $results );
      $this->testables = $results;
      return $results;
    }

    public function run() {
      if ( count( $this->testables ) > 0 ) {
        // We have some testables blocks.
        foreach ( $this->testables as $testBlock ) {
          // One block might have more than one test file.
          foreach ( $testBlock[ 'files' ] as $testFile ) {
            // Importing the test file.
            require_once $testBlock[ 'path' ] . DIRECTORY_SEPARATOR . $testFile;
            // Call the test.
            // ...
          }
        }
      }
    }

  }