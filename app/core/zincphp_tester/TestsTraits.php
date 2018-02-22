<?php

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
            echo \ZincPHP\CLI\Helper\success( "✔ HTTP response status code matched." );
            \ZincPHP\CLI\Helper\nl();
          } else {
            $flag = false;
          }
        } else {
          $this->fetchedResponse[ 'header' ][ 'http_code' ] = '';
          $flag = false;
        }
        if ( ! $flag ) {
          echo \ZincPHP\CLI\Helper\danger( "✘ HTTP response status code doesnt matched." );
          \ZincPHP\CLI\Helper\nl();
          echo \ZincPHP\CLI\Helper\warn( "- Expected: " . $this->expectedResponseStatus . "\tFound: " . $this->fetchedResponse[ 'header' ][ 'http_code' ] );
          \ZincPHP\CLI\Helper\nl();
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
            echo \ZincPHP\CLI\Helper\success( "✔ Content type matched." );
            \ZincPHP\CLI\Helper\nl();
          } else {
            $flag = false;
          }
        } else {
          $flag = false;
          $this->fetchedResponse[ 'header' ][ 'content_type' ] = '';
        }
        if ( ! $flag ) {
          echo \ZincPHP\CLI\Helper\danger( "✘ Content type doesnt matched." );
          \ZincPHP\CLI\Helper\nl();
          echo \ZincPHP\CLI\Helper\warn( "- Expected: " . $this->expectedContentTypeValue . "\tFound: " . $this->fetchedResponse[ 'header' ][ 'content_type' ] );
          \ZincPHP\CLI\Helper\nl();
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
            echo \ZincPHP\CLI\Helper\success( "✔ Empty response found as expected." );
            \ZincPHP\CLI\Helper\nl();
          } else {
            echo \ZincPHP\CLI\Helper\danger( "✘ Empty response was not found as expected." );
            \ZincPHP\CLI\Helper\nl();
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
          echo \ZincPHP\CLI\Helper\success( "✔ Response data matched with expected data." );
          \ZincPHP\CLI\Helper\nl();
        } else {
          echo \ZincPHP\CLI\Helper\danger( "✘ Response data doesnt matched with expected data." );
          \ZincPHP\CLI\Helper\nl();
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
        $validator = new ZincValidator;
        // Generate the validator rules with the value.
        foreach ( $this->responseDataValidator as $key => $rule ) {
          $this->responseDataValidator[ $key ][ 'value' ] = $this->getResponseData( $key );
        }
        $v = $validator->validate( $this->responseDataValidator, '', false );
        if ( $v ) {
          print "Success\n";
          print_r($v);
        } else {
          print "Failed\n";
          print_r($v);
        }

        // print_r( $this->responseDataValidator );
        // print_r( $this->getResponseData() );
      }
    }

    

  }