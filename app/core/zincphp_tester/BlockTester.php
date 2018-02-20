<?php

  require_once __DIR__ . '/TestsTraits.php';
  
  class BlockTester {

    use TestsTraits;

    public $blockPath;
    public $requestUrl;
    public $fetchedResponse;
    public $expectedContentType;
    public $requestMethod;
    public $testSuccess;
    public $testFileName;
    
    // Variables that contains test data.
    public $headers;
    public $parameters;
    public $expectedResponseStatus;
    public $expectEmptyResponse;
    public $expectedData;
    public $responseDataValidator;

    function __construct() {
      
      // Setting a global flag that later tells if this test was successful or not.
      $this->testSuccess = true;

      // Set default values to test varaibles, so later we can descide which tests to run.
      $this->headers                  = "ZincPHP_" . md5( "headers" );
      $this->parameters               = "ZincPHP_" . md5( "parameters" );
      $this->expectedResponseStatus   = "ZincPHP_" . md5( "expectedResponseStatus" );
      $this->expectEmptyResponse      = "ZincPHP_" . md5( "expectEmptyResponse" );
      $this->expectedData             = "ZincPHP_" . md5( "expectedData" );
      $this->responseDataValidator    = "ZincPHP_" . md5( "responseDataValidator" );

    }

    public function setHeaders ( $headers = [] ) {
      if ( ! empty( $headers ) ) {
        $this->headers = $headers;
      }
    }

    public function setParameters ( $parameters = [] ) {
      if ( ! empty( $parameters ) ) {
        $this->parameters = $parameters;
      }
    }

    public function testHas ( $testTypeName ) {
      if ( $this->$testTypeName === "ZincPHP_" . md5( trim( $testTypeName ) ) ) return false;
      else return true;
    }

    public function setTestFileName( $file ) {
      $this->testFileName = $file;
    }

    private function makeRequest( $requester ) {
      $_funcName = "HTTP" . ucfirst( $this->requestMethod );
      $this->fetchedResponse = $requester->$_funcName( $this->requestUrl, $this->parameters, $this->headers );
    }

    public function generateUrlFromPath( $requestUrl, $devServer ) {
      $requestUrl = preg_replace( '/\/tests$/', '', $requestUrl );
      $pos = strpos( $requestUrl, 'blocks' );
      if ( $pos !== false ) {
        $requestUrl = substr_replace( $requestUrl, '456789238473892___block', $pos, strlen( 'blocks' ) );
      }
      if ( isset( explode( '456789238473892___block', $requestUrl )[ 1 ] ) ) {
        $this->blockPath = explode( '456789238473892___block', $requestUrl )[ 1 ];
        $this->requestUrl = 'http://' . trim( $devServer ) . '?route=' . $this->blockPath;
      }
    }

    public function setRequestMethod( $testFileName ) {
      $_method = explode( '.', $testFileName );
      $this->requestMethod = $_method[ 0 ];
    }

    public function runTest( $requester ) {
      
      print "Testing:\t" . $this->blockPath . " (" . strtoupper( $this->requestMethod ) . " request)";
      \ZincPHP\CLI\Helper\nl();
      print "Test File:\t" . $this->testFileName;
      \ZincPHP\CLI\Helper\nl();
      $this->makeRequest( $requester );

      $this->testStatus();
      $this->testContentType();

      \ZincPHP\CLI\Helper\nl();
      sleep(0.30); // Safes from any unexpected attack.

    }

  }