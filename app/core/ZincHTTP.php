<?php

/**
 * Send HTTP request to an REST end-point.
 *
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
    $response = curl_exec( $ch );
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
    $response = curl_exec( $ch );
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
    $response = \curl_exec( $ch );
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