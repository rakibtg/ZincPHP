<?php

  namespace ZincPHP\Response;

  /**
   * The response method of ZincPHP.
   * Send HTTP response to end clients.
   * 
   * @author Hasan <rakibtg@gmail.com>
   * @link ...
   */

  class ZincResponse {

    protected $raw;
    protected $data;
    protected $exit;
    protected $error;
    protected $status;
    protected $pretty;
    protected $success;
    protected $failed;
    protected $contentType;

    function __construct( $data = [] ) {
      $this->raw          = false;
      $this->exit         = false;
      $this->data         = $data;
      $this->error        = false;
      $this->pretty       = false;
      $this->failed       = false;
      $this->status       = 200;
      $this->success      = false;
      $this->contentType  = 'application/json';
    }

    public function error( $status = 500 ) {
      $this->status = $status;
      if( empty( $this->data ) ) $this->data = 'Internal Server Error';
      return $this;
    }

    public function status( $status = 200 ) {
      $this->status = $status;
      return $this;
    }

    public function pretty( $pretty = true ) {
      $this->pretty = $pretty;
      return $this;
    }

    public function success() {
      $this->success = true;
      return $this;
    }

    public function failed() {
      $this->failed = true;
      return $this;
    }

    public function raw() {
      $this->raw = true;
      return $this;
    }

    public function exit( $exit = true ) {
      $this->exit = $exit;
      return $this;
    }

    public function contentType( $contentType = 'application/json' ) {
      $this->contentType = $contentType;
      return $this;
    }

    protected function statusType() {
      if( $this->success ) return true;
      else if ( $this->failed ) return false;
      else if( $this->status === 200 )  return true;
      else return false;
    }

    protected function makeResponse() {
      if( !$this->raw ) {
        // Response a response with related information's.
        $data = [
          'body'         => $this->data,
          'status'       => $this->status,
          'content_type' => $this->contentType,
          'success'      => $this->statusType()
        ];
        if( $this->pretty === true ) $data = json_encode( $data, JSON_PRETTY_PRINT );
        else $data = json_encode( $data );
      } else {
        // Return a RAW string / array response.
        if( $this->pretty === true ) $data = json_encode( $this->data, JSON_PRETTY_PRINT );
        else $data = json_encode( $this->data );
      }
      echo $data;
    }

    /**
     * Converts data to json then print it.
     *
     * @return void
     */
    public function send() {
      // Setting the response code of the output.
      http_response_code( $this->status );
      // Setting the response content type.
      header( 'Content-Type: ' . $this->contentType . '; charset=utf-8' );
      // Prepare the response.
      $this->makeResponse();
      // Exit from the app after the response.
      if( $this->exit === true ) exit();
    }

  }