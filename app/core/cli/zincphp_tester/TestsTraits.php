<?php

  use \ZincPHP\CLI\Helper as CLI;

  /**
    Expected Response Status - implemented
    Expected Content Type - implemented
    Expect Empty Response
    Expected Data
    Response Data Validator
    File upload
   */

  trait TestsTraits {

    /**
     * Check if the status is expected.
     */
    public function testStatus() {
      if ( $this->testHas( 'expectedResponseStatus' ) ) {
        $flag = true;
        if ( isset( $this->fetchedResponse[ 'header' ][ 'http_code' ] ) ) {
          if ( $this->fetchedResponse[ 'header' ][ 'http_code' ] == $this->expectedResponseStatus ) {
            echo CLI\success( "✔ HTTP response status code matched." );
            CLI\nl();
          } else {
            $flag = false;
          }
        } else {
          $this->fetchedResponse[ 'header' ][ 'http_code' ] = '';
          $flag = false;
        }
        if ( ! $flag ) {
          echo CLI\danger( "✘ HTTP response status code doesnt matched." );
          CLI\nl();
          echo CLI\warn( "- Expected: " . $this->expectedResponseStatus . "\tFound: " . $this->fetchedResponse[ 'header' ][ 'http_code' ] );
          CLI\nl();
        }
        if ( $this->testSuccess !== false ) $this->testSuccess = $flag;
      }
    }

    /**
     * Check if content type is expected.
     */
    public function testContentType() {
      if ( $this->testHas( 'expectedContentTypeValue' ) ) {
        $flag = true;
        if ( isset( $this->fetchedResponse[ 'header' ][ 'content_type' ] ) ) {
          if ( strpos( $this->fetchedResponse[ 'header' ][ 'content_type' ], $this->expectedContentTypeValue ) !== false ) {
            echo CLI\success( "✔ Content type matched." );
            CLI\nl();
          } else {
            $flag = false;
          }
        } else {
          $flag = false;
          $this->fetchedResponse[ 'header' ][ 'content_type' ] = '';
        }
        if ( ! $flag ) {
          echo CLI\danger( "✘ Content type doesnt matched." );
          CLI\nl();
          echo CLI\warn( "- Expected: " . $this->expectedContentTypeValue . "\tFound: " . $this->fetchedResponse[ 'header' ][ 'content_type' ] );
          CLI\nl();
        }
        if ( $this->testSuccess !== false ) $this->testSuccess = $flag;
      }
    }

    /**
     * Check if expecting empty response.
     */
    public function expectEmptyResponse() {
      if ( $this->testHas( 'expectEmptyResponse' ) ) {
        if ( $this->expectEmptyResponse === true ) {
          $flag = true;
          // Prepare data.
          if ( empty( $this->fetchedResponse[ 'content' ] ) ) {
            $content = [];
          } else {
            $content = json_decode( $this->fetchedResponse[ 'content' ] );
          }
          if ( $content !== [] ) {
            $flag = false;
          }
          if ( $flag === true ) {
            echo CLI\success( "✔ Empty response found as expected." );
            CLI\nl();
          } else {
            echo CLI\danger( "✘ Empty response was not found as expected." );
            CLI\nl();
          }
          if ( $this->testSuccess !== false ) $this->testSuccess = $flag;
        }
      }
    }

    /**
     * Chekc if response is exact same as expected.
     */
    public function testExactResponseData() {
      if ( $this->testHas( 'expectedDataValue' ) ) {
        $flag = true;
        if ( is_array( $this->expectedDataValue ) ) {
          $content = json_decode( $this->fetchedResponse[ 'content' ], true );
          if ( $this->expectedDataValue != $content ) $flag = false;
        } else if ( is_object( $this->expectedDataValue ) ) {
          $content = json_decode( $this->fetchedResponse[ 'content' ] );
          if ( $this->expectedDataValue != $content ) $flag = false;
        } else {
          if ( $this->expectedDataValue !== $this->fetchedResponse[ 'content' ] ) $flag = false;
        }
        if ( $flag === true ) {
          echo CLI\success( "✔ Response data matched with expected data." );
          CLI\nl();
        } else {
          echo CLI\danger( "✘ Response data doesnt matched with expected data." );
          CLI\nl();
        }
        if ( $this->testSuccess !== false ) $this->testSuccess = $flag;
      }
    }

    /**
     * Check if data is validated.
     */
    public function dataValidator() {
      if ( $this->testHas( 'responseDataValidator' ) ) {
        $flag = true;
        $validator = new \ZincPHP\validator\ZincValidator;
        // Generate the validator rules with the value.
        foreach ( $this->responseDataValidator as $key => $rule ) {
          $this->responseDataValidator[ $key ][ 'value' ] = $this->getResponseData( $key );
        }
        $validated = $validator->validate( $this->responseDataValidator, '', false );
        if ( $validated[ 'status' ] === 'valid' ) {
          echo CLI\success( "✔ Response data validated successfully." );
          CLI\nl();
        } else {
          echo CLI\danger( "✘ Failed to validate response data, reasons: " );
          CLI\nl();
          foreach ( $validated[ 'message' ] as $er ) {
            echo CLI\warn( "  - " . $er );
            CLI\nl();
          }
          $flag = false;
        }
        if ( $this->testSuccess !== false ) $this->testSuccess = $flag;
      }
    }



  }
