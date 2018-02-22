<?php

  // A test file.
  class Putunittest extends BlockTester {

    public function metaData () {
      $this->setHeaders( [] );
      $this->setParameters( [] );
    }
 
    public function setExpectations () {
      // $this->expectedResponseStatus = 200;
      $this->expectedHTTPCode( 200 );
      // $this->expectedContentTypeValue = 'application/json';
      $this->expectedContentType( 'application/json' );
      // $this->expectEmptyResponse = false;
      // $this->expectedDataValue = ['name' => 'Hello World!'];
      $this->expectedData( [ 'name' => 'Hello World!' ] );
      // $this->responseDataValidator = [
      //   'name' => [
      //     'rules' => 'required|lengthMax:120',
      //     'value' => $this->getResponseData( 'name' ) // $this->getResponseData()[ 0 ][ 'name ] ; just check the first item of a array of result.
      //   ]
      // ];
      $rules = [
        'name' => [
          'rules' => 'required|email|array|max:2',
          'value' => $this->getResponseData( 'name' ) // $this->getResponseData()[ 0 ][ 'name ] ; just check the first item of a array of result.
        ]
      ];
      $this->validateExpectedData( $rules );
      
    }

  }