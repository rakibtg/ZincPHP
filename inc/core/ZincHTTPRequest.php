<?php

/**
 * Send HTTP request to an REST end-point.
 *
 */
class HTTPRequester {
  /**
   * Make HTTP-GET call
   * @param       $url
   * @param       array $params
   * @return      HTTP-Response body or an empty string if the request fails or is empty
   */
  public static function HTTPGet( $url, array $params ) {
    $query = http_build_query( $params ); 
    $ch    = curl_init( $url.'?'.$query );
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
  public static function HTTPPost( $url, array $params ) {
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
   * Make HTTP-PUT call
   * @param       $url
   * @param       array $params
   * @return      HTTP-Response body or an empty string if the request fails or is empty
   */
  public static function HTTPPut( $url, array $params ) {
    $query = \http_build_query( $params );
    $ch    = \curl_init();
    \curl_setopt( $ch, \CURLOPT_RETURNTRANSFER, true );
    \curl_setopt( $ch, \CURLOPT_HEADER, false );
    \curl_setopt( $ch, \CURLOPT_URL, $url );
    \curl_setopt( $ch, \CURLOPT_CUSTOMREQUEST, 'PUT' );
    \curl_setopt( $ch, \CURLOPT_POSTFIELDS, $query );
    $response = \curl_exec( $ch );
    \curl_close( $ch );
    return $response;
  }

  /**
   * Make HTTP-DELETE call
   * @param    $url
   * @param    array $params
   * @return   HTTP-Response body or an empty string if the request fails or is empty
   */
  public static function HTTPDelete( $url, array $params ) {
    $query = \http_build_query( $params );
    $ch    = \curl_init();
    \curl_setopt( $ch, \CURLOPT_RETURNTRANSFER, true );
    \curl_setopt( $ch, \CURLOPT_HEADER, false );
    \curl_setopt( $ch, \CURLOPT_URL, $url );
    \curl_setopt( $ch, \CURLOPT_CUSTOMREQUEST, 'DELETE' );
    \curl_setopt( $ch, \CURLOPT_POSTFIELDS, $query );
    $response = \curl_exec( $ch );
    \curl_close( $ch );
    return $response;
  }
}