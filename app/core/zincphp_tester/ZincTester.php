<?php

  require_once __DIR__ . '/../ZincHTTP.php';

  class ZincTester {

    public $blocksCount;
    public $testFilesCount;
    public $testables;
    public $devServer;
    public $allTestsPassed;

    function __construct() {

      $this->blocksCount    = 0;
      $this->testFilesCount = 0;
      $this->testables      = [];
      $this->devServer      = '127.0.0.1:8585';
      $this->allTestsPassed = true;

      $this->getTestableBlocks();

    }

    /**
     * Generate the class name for the test file name.
     * 
     * @param   string $testFile Test file name
     * @return  string Class name of the test file.
     */
    function makeTestClassName( $testFile ) {
      $testFile = trim( str_replace( '_', '', $testFile ) );
      $testFile = str_replace( '-', '', $testFile );
      $testFile = str_replace( '.test.php', '', $testFile );
      $testFile = str_replace( '.', '', $testFile );
      return ucfirst( $testFile );
    }

    /**
     * Browser each tests directory of each block and pluck the test files.
     * 
     * @param   boolean|string $dir When is is false then define the blocks path.
     * @param   array $testableFilesList Array of testable blocks and test files.
     */
    function getTestableBlocks( $dir = false, &$testableFilesList = [] ) {
      if ( $dir === false ) $dir = './blocks';
      $files = scandir( $dir );
      foreach( $files as $key => $value ){
        $path = realpath( $dir . DIRECTORY_SEPARATOR . $value );
        if( is_dir( $path ) ) {
          if( $value != "." && $value != ".." ) {
            $this->getTestableBlocks( $path, $testableFilesList );
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
                $testableFilesList[] = $testable;
              }
            }
          }
        }
      }
      $this->blocksCount = count( $testableFilesList );
      $this->testables = $testableFilesList;
      return $testableFilesList;
    }

    /**
     * Start the test.
     * 
     * @param   array $argv Array of the system arguments.
     * @return  void
     */
    public function run( $argv ) {
      // Set the dev domain.
      if ( is_array( $argv ) ) {
        foreach ( $argv as $arg ) {
          if ( strpos( $arg, '=' ) !== false ) {
            $_ds = explode( '=', $arg );
            if ( trim( $_ds[ 0 ] ) === '--server' ) {
              if ( isset( $_ds[ 1 ] ) ) {
                $this->devServer = $_ds[ 1 ];
              }
            }
          }
        }
      }

      \ZincPHP\CLI\Helper\nl();
      echo 'Starting test, make sure the dev server is running at ' . $this->devServer;
      \ZincPHP\CLI\Helper\nl();

      if ( count( $this->testables ) > 0 ) {
        // We have some test files.
        echo \ZincPHP\CLI\Helper\success( 
          $this->blocksCount . " blocks and " . $this->testFilesCount . " files to test." 
        );
        \ZincPHP\CLI\Helper\nl();
        \ZincPHP\CLI\Helper\nl();

        sleep(2); // Safes from any unexpected attack.

        // Create new instance of the zinc http module.
        $requester = new ZincHTTP();

        // We have some testables blocks.
        foreach ( $this->testables as $testBlock ) {
          // One block might have more than one test file.
          foreach ( $testBlock[ 'files' ] as $testFile ) {
            // Importing the test file.
            require_once $testBlock[ 'path' ] . DIRECTORY_SEPARATOR . $testFile;
            // Start the test.
            // Generate the class name of the test class.
            $_className  = $this->makeTestClassName( $testFile ); 
            // Dynamically create a new instance of the test class.
            $blockTester = new $_className(); 
            // Passing the block name into the block tester class.
            $blockTester->generateUrlFromPath( $testBlock[ 'path' ], $this->devServer ); 
            $blockTester->setRequestMethod( $testFile );
            $blockTester->setTestFileName( $testFile );
            $blockTester->metaData();
            $blockTester->setExpectations();
            if ( $blockTester->runTest( $requester ) === false ) $this->allTestsPassed = false;
          } // End of $testBlock[ 'files' ] loop.
        } // End of $this->testables loop.

        echo "➜ All tests completed";
        // Check if all tests are passed.
        if ( $this->allTestsPassed === true ) {
          echo \ZincPHP\CLI\Helper\success( " (✔ PASSED)" );
        } else {
          echo \ZincPHP\CLI\Helper\danger( " (✘ FAILED)" );
        }
        \ZincPHP\CLI\Helper\nl();
        \ZincPHP\CLI\Helper\nl();
      } else {
        echo \ZincPHP\CLI\Helper\danger( "No tests found!" );
        \ZincPHP\CLI\Helper\nl();
      }
    }

  }