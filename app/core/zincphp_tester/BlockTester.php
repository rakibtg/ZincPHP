<?php

  require_once __DIR__ . '/TestsTraits.php';
  
  class BlockTester {

    use TestsTraits;

    public $requestUrl;
    public $parameters;
    public $fetchedResponse;
    public $expectedResponseStatus;
    public $expectEmptyResponse;
    public $expectedData;
    public $responseDataValidator;
    public $expectedContentType;
    public $requestMethod;

    public $testSuccess;

    function __construct() {
      $this->testSuccess = true;
    }

    private function makeRequest( $requester ) {
      $_funcName = "HTTP" . ucfirst( $this->requestMethod );
      $this->fetchedResponse = $requester->$_funcName( $this->requestUrl, $this->parameters );
    }

    public function generateUrlFromPath( $requestUrl, $devServer ) {
      $requestUrl = preg_replace( '/\/tests$/', '', $requestUrl );
      $pos = strpos( $requestUrl, 'blocks' );
      if ( $pos !== false ) {
        $requestUrl = substr_replace( $requestUrl, '456789238473892___block', $pos, strlen( 'blocks' ) );
      }
      if ( isset( explode( '456789238473892___block', $requestUrl )[ 1 ] ) ) {
        $this->requestUrl = explode( '456789238473892___block', $requestUrl )[ 1 ];
      }

    }

    public function setRequestMethod( $testFileName ) {
      $_method = explode( '.', $testFileName );
      $this->requestMethod = $_method[ 0 ];
    }

    public function runTest( $requester ) {
      $this->makeRequest( $requester );
      $this->testStatus();
      $this->testContentType();
      // print_r( $this->parameters );
      // echo "\n";
      // print_r( $this->expectedResponseStatus );
      // echo "\n";
      // print_r( $this->expectEmptyResponse );
      // echo "\n";
      // print_r( $this->expectedData );
      // echo "\n";
      // print_r( $this->responseDataValidator );
      // echo "\n";
    }

  }