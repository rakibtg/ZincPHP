<?php

  class BlockTester {

    public $requestUrl;
    public $parameters;
    public $expectedResponseStatus;
    public $expectEmptyResponse;
    public $expectedData;
    public $responseDataValidator;

    // private function makeRequest() {

    // }

    public function generateUrlFromPath( $requestUrl ) {
      $requestUrl = preg_replace( '/\/tests$/', '', $requestUrl );
      $pos = strpos( $requestUrl, 'blocks' );
      if ( $pos !== false ) {
        $requestUrl = substr_replace( $requestUrl, '456789238473892___block', $pos, strlen( 'blocks' ) );
      }
      if ( isset( explode( '456789238473892___block', $requestUrl )[ 1 ] ) ) {
        $this->requestUrl = explode( '456789238473892___block', $requestUrl )[ 1 ];
        print "Request URL: " . $this->requestUrl . "\n\n";
      }
    }

    public function runTest() {

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