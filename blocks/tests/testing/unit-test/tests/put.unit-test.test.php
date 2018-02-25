<?php

  // A test file.
  class Putunittest extends BlockTester {

    public function metaData () {
      print __DIR__ . "\n";
      $this->setHeaders( [] );
      $this->setParameters( [] );
      $this->setFiles( [
        'photo' => '/girl.jpg'
      ] );
    }

    public function setExpectations () {
      $this->expectedHTTPCode( 200 );
      $this->expectedContentType( 'application/json' );
      $this->expectedData( [ 'name' => 'Hello World!' ] );
      $this->validateExpectedData( [
        'name' => [
          'rules' => 'required',
          'value' => $this->getResponseData( 'name' )
        ]
      ] );
    }

  }
