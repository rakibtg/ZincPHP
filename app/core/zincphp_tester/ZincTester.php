<?php

  class ZincTester {
    public $blocksCount;
    public $testFilesCount;

    function __construct() {
      $this->blocksCount = 0;
      $this->testFilesCount = 0;
    }

    function getTestDirectories($dir = false, &$results = array()){

      if ( $dir === false ) $dir = './blocks';
      $files = scandir($dir);
  
      foreach($files as $key => $value){
          $path = realpath( $dir . DIRECTORY_SEPARATOR . $value );
          if(is_dir($path)) {
            if($value != "." && $value != "..") {
              $this->getTestDirectories($path, $results);
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
      return $results;
  }
  

  }