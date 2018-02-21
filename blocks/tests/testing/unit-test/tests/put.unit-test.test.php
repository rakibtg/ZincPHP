<?php

  // A test file.
  class Putunittest extends BlockTester {

    public function metaData () {
      $this->setHeaders( [] );
      $this->setParameters( [] );
    }

    public function setExpectations () {
      $this->expectedResponseStatus = 200;
      $this->expectedContentType = 'application/json';
      $this->expectEmptyResponse = false;
      $this->expectedData = ['name' => 'Hello World!'];
      $this->responseDataValidator = [
        'name' => [
          'rules' => 'required|lengthMax:120',
          'value' => $this->getResponseData( 'name' ) // $this->getResponseData()[ 0 ][ 'name ] ; just check the first item of a array of result.
        ]
      ];
    }

  }