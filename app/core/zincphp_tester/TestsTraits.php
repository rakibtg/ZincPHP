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
    }

    /**
     * Check if content type is expected.
     */
    public function testContentType() {
      $flag = true;
      if ( isset( $this->fetchedResponse[ 'header' ][ 'content_type' ] ) ) {
        if ( strpos( $this->fetchedResponse[ 'header' ][ 'content_type' ], $this->expectedContentType ) !== false ) {
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
        echo \ZincPHP\CLI\Helper\warn( "- Expected: " . $this->expectedContentType . "\tFound: " . $this->fetchedResponse[ 'header' ][ 'content_type' ] );
        \ZincPHP\CLI\Helper\nl();
      }
    }

    public function testEmptyResponse() {

    }

    public function testExactResponseData() {

    }

    public function dataValidator() {

    }

    

  }