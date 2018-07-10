<?php

  trait ExpectationsTrait {

    /**
     * Sets the http expected response code.
     * @param  integer $httpCode Default will be 200
     */
    public function expectedHTTPCode ( $httpCode = 200 ) {
      $this->expectedResponseStatus = $httpCode;
    }

    /**
     * Sets the expected content type.
     * @param   string $contentType Default content type is 'application/json'
     */
    public function expectedContentType ( $contentType = 'application/json' ) {
      $this->expectedContentTypeValue = $contentType;
    }

    /**
     * Sets the flag that if the expected response should be empty.
     */
    public function expectedEmpty () {
      $this->expectEmptyResponse = true;
    }

    /**
     * Sets the expected data.
     * @param   array $data Data to match against the response content.
     */
    public function expectedData ( $data = [] ) {
      $this->expectedDataValue = $data;
    }

    /**
     * validate response data.
     */
    public function validateExpectedData ( $rules = [], $onlyFirstIteration = false ) {
      $this->responseDataValidator = $rules;
      $this->dataValidateOnlyFirstIteration = true;
    }

  }