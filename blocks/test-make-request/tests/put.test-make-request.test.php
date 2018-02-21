<?php

  // A test file.
  class Puttestmakerequest extends BlockTester {

    public function metaData () {
      $this->setHeaders( [] );
      $this->setParameters( [] );
    }

    public function setExpectations () {
      $this->expectedResponseStatus = 200;
      $this->expectedContentType = 'application/json';
      $this->expectEmptyResponse = false;
      $this->expectedData = [ 'status' => 'hello from put block' ];
      // $this->responseDataValidator = 'required|max:1000|string';
    }

  }