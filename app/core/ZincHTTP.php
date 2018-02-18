<?php

/**
 * Send HTTP request to an REST end-point.
 *
 */


/*

  A SAMPLE RESPONSE DATA
  [
    {
      "content": "hello world",
      "header": {
        "url": "http:\/\/127.0.0.1:2080\/?route=test-make-request",
        "content_type": "application\/json; charset=utf-8",
        "http_code": 200,
        "header_size": 202,
        "request_size": 146,
        "filetime": -1,
        "ssl_verify_result": 0,
        "redirect_count": 0,
        "total_time": 0.001458,
        "namelookup_time": 6.0e-5,
        "connect_time": 0.00032,
        "pretransfer_time": 0.000441,
        "size_upload": 0,
        "size_download": 25,
        "speed_download": 17146,
        "speed_upload": 0,
        "download_content_length": -1,
        "upload_content_length": 0,
        "starttransfer_time": 0.001327,
        "redirect_time": 0,
        "redirect_url": "",
        "primary_ip": "127.0.0.1",
        "certinfo": [],
        "primary_port": 2080,
        "local_ip": "127.0.0.1",
        "local_port": 48964
      }
    },
    ...
  ]

*/



class ZincHTTP {
  /**
   * Make HTTP-GET call
   * @param       $url
   * @param       array $params
   * @return      HTTP-Response body or an empty string if the request fails or is empty
   */
  public function HTTPGet( $url, $params = [] ) {
    $query = http_build_query( $params ); 
    $ch    = curl_init( $url . '?' . $query );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch, CURLOPT_HEADER, false );
    $response[ 'content' ] = curl_exec( $ch );
    $response[ 'header' ] = curl_getinfo( $ch );
    curl_close( $ch );
    return $response;
  }

  /**
   * Make HTTP-POST call
   * @param       $url
   * @param       array $params
   * @return      HTTP-Response body or an empty string if the request fails or is empty
   */
  public function HTTPPost( $url, $params = [] ) {
    $query = http_build_query( $params );
    $ch    = curl_init();
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch, CURLOPT_HEADER, false );
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_POST, true );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $query );
    $response[ 'content' ] = curl_exec( $ch );
    $response[ 'header' ] = curl_getinfo( $ch );
    curl_close( $ch );
    return $response;
  }

  /**
   * Formula to make any HTTP-POST requests.
   * @param       $url
   * @param       array   $params
   * @param       string  The method name.
   * @return      HTTP-Response body or an empty string if the request fails or is empty.
   */
  private function makeRequestsFormula( $url, $params, $method ) {
    $query = \http_build_query( $params );
    $ch    = \curl_init();
    \curl_setopt( $ch, \CURLOPT_RETURNTRANSFER, true );
    \curl_setopt( $ch, \CURLOPT_HEADER, false );
    \curl_setopt( $ch, \CURLOPT_URL, $url );
    \curl_setopt( $ch, \CURLOPT_CUSTOMREQUEST, $method );
    \curl_setopt( $ch, \CURLOPT_POSTFIELDS, $query );
    $response[ 'content' ] = curl_exec( $ch );
    $response[ 'header' ] = curl_getinfo( $ch );
    \curl_close( $ch );
    return $response;
  }
  /**
   * Make HTTP-PUT call
   * @param       $url
   * @param       array $params Parameters with the request.
   * @return      HTTP-Response body or an empty string if the request fails or is empty
   */
  public function HTTPPut( $url, $params = [] ) {
    return $this->makeRequestsFormula( $url, $params, 'PUT' );
  }

  /**
   * Make HTTP-DELETE call
   * @param    $url
   * @param    array $params
   * @return   HTTP-Response body or an empty string if the request fails or is empty
   */
  public function HTTPDelete( $url, $params = [] ) {
    return $this->makeRequestsFormula( $url, $params, 'DELETE' );
  }

  /**
   * Make HTTP-COPY call
   * @param    $url
   * @param    array $params
   * @return   HTTP-Response body or an empty string if the request fails or is empty
   */
  public function HTTPCopy( $url, $params = [] ) {
    return $this->makeRequestsFormula( $url, $params, 'COPY' );
  }

  /**
   * Make HTTP-OPTIONS call
   * @param    $url
   * @param    array $params
   * @return   HTTP-Response body or an empty string if the request fails or is empty
   */
  public function HTTPOptions( $url, $params = [] ) {
    return $this->makeRequestsFormula( $url, $params, 'OPTIONS' );
  }

  /**
   * Make HTTP-PATCH call
   * @param    $url
   * @param    array $params
   * @return   HTTP-Response body or an empty string if the request fails or is empty
   */
  public function HTTPPatch( $url, $params = [] ) {
    return $this->makeRequestsFormula( $url, $params, 'PATCH' );
  }

  /**
   * Make HTTP-PROPFIND call
   * @param    $url
   * @param    array $params
   * @return   HTTP-Response body or an empty string if the request fails or is empty
   */
  public function HTTPPropfind( $url, $params = [] ) {
    return $this->makeRequestsFormula( $url, $params, 'PROPFIND' );
  }

}