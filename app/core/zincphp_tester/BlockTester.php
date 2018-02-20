<?php

  require_once __DIR__ . '/TestsTraits.php';
  
  class BlockTester {

    use TestsTraits;

    public $blockPath;
    public $requestUrl;
    public $fetchedResponse;
    public $requestMethod;
    public $testSuccess;
    public $testFileName;
    
    // Variables that contains test data.
    public $headers;
    public $parameters;
    public $expectedResponseStatus;
    public $expectEmptyResponse;
    public $expectedContentType;
    public $expectedData;
    public $responseDataValidator;

    function __construct() {
      
      // Setting a global flag that later tells if this test was successful or not.
      $this->testSuccess = true;

      // Set default values to test varaibles, so later we can descide which tests to run.
      $this->headers                  = [];
      $this->parameters               = [];
      $this->expectedResponseStatus   = "ZincPHP_" . md5( "expectedResponseStatus" );
      $this->expectEmptyResponse      = "ZincPHP_" . md5( "expectEmptyResponse" );
      $this->expectedData             = "ZincPHP_" . md5( "expectedData" );
      $this->responseDataValidator    = "ZincPHP_" . md5( "responseDataValidator" );

    }

    /**
     * Set header with the test request.
     * 
     * @param   array $headers Array of headers should pass with the test request.
     * @return  void
     */
    public function setHeaders ( $headers = [] ) {
      if ( ! empty( $headers ) ) {
        $this->headers = $headers;
      }
    }

    /**
     * Set parameters with the test requests.
     * 
     * @param   array @parameters Array of parameters should pass with the test request.
     * @return  void
     */
    public function setParameters ( $parameters = [] ) {
      if ( ! empty( $parameters ) ) {
        $this->parameters = $parameters;
      }
    }

    /**
     * Check if a test exists in a test file.
     * For example: if a test file has "expectedResponseStatus" test, or not.
     * 
     * @param   string $testTypeName Name of the test.
     * @return  boolean If a test type exists then it will return true or false either.
     */
    public function testHas ( $testTypeName ) {
      if ( $this->$testTypeName === "ZincPHP_" . md5( trim( $testTypeName ) ) ) return false;
      else return true;
    }


    /**
     * Set a test file name.
     * 
     * @param   string $file Name of the test file.
     * @return  void
     */
    public function setTestFileName( $file ) {
      $this->testFileName = $file;
    }

    /**
     * Makes the actual test request to a block.
     * 
     * @param   object $requester The instantiated object of the ZincHTTP class
     * @return  void
     */
    private function makeRequest( $requester ) {
      $_funcName = "HTTP" . ucfirst( $this->requestMethod );
      $this->fetchedResponse = $requester->$_funcName( $this->requestUrl, $this->parameters, $this->headers );
    }

    /**
     * Generates the block path from the full path to the block, then
     * concat with the dev server to make the requestable URL path to the block.
     * 
     * @param   string $requestUrl The block path
     * @param   string $devServer The development domain of the server
     * @return  void
     */
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

    /**
     * Dynamically look for the request method from the block name.
     * 
     * @param   string $testFileName Test file name.
     * @return  void
     */
    public function setRequestMethod( $testFileName ) {
      $_method = explode( '.', $testFileName );
      $this->requestMethod = $_method[ 0 ];
    }

    /**
     * Run the test of current block
     * 
     * @param   object $requester The instantiated object of the ZincHTTP class
     * @return  void
     */
    public function runTest( $requester ) {
      
      print "Testing:\t" . $this->blockPath . " (" . strtoupper( $this->requestMethod ) . " request)";
      \ZincPHP\CLI\Helper\nl();
      print "Test File:\t" . $this->testFileName;
      \ZincPHP\CLI\Helper\nl();

      $this->makeRequest( $requester );
      $this->testStatus();
      $this->testContentType();
      $this->expectEmptyResponse();
      $this->testExactResponseData();

      \ZincPHP\CLI\Helper\nl();
      sleep(0.30); // Safes from any unexpected attack.

      return $this->testSuccess; // returns true on successful test, if fails then returns false.

    }

  }