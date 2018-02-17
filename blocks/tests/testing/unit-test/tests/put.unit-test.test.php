<?php

  // A test file.
  class Putunittest extends BlockTester {

    public function makeTest() {

      $this->parameters = [];

      $this->expectedResponseStatus = '200';

      $this->expectEmptyResponse = false;

      $this->expectedData = null;

      $this->responseDataValidator = 'required|max:1000|string';

    }

  }