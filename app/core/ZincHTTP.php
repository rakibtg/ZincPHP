<?php

/**
 * Send HTTP request to an REST end-point.
 *
 */

/*
  A SAMPLE RESPONSE DATA
    {
      "content": "hello world",
      "header": {
        "content_type": "application\/json; charset=utf-8",
        "http_code": 200,
        ... ...
      }
    }
*/

class ZincHTTP {

  /**
   * Make HTTP-GET call
   * @param       $url
   * @param       array $params List of parameters
   * @param       array $headers List of custom headers
   * @return      HTTP-Response body or an empty string if the request fails or is empty
   */
  public function HTTPGet( $url, $params = [], $headers = [] ) {
    $query = http_build_query( $params );
    $ch    = curl_init( $url . '?' . $query );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch, CURLOPT_HEADER, false );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
    $response[ 'content' ] = curl_exec( $ch );
    $response[ 'header' ]  = curl_getinfo( $ch );
    curl_close( $ch );
    return $response;
  }

  /**
   * Make HTTP-POST call
   * @param       $url
   * @param       array $params
   * @param       array $headers
   * @return      HTTP-Response body or an empty string if the request fails or is empty
   */
  public function HTTPPost( $url, $params = [], $headers = [], $files = [] ) {

    // Check if we have any files.
    if ( ! empty( $files ) ) {
      // Prepare array of the files path.
      foreach ( $files as $key => $file ) {
        $files[ $key ] = '@' . __DIR__ . '/../../' . trim( $files[ $key ], '/' );
      }
      // Merge files with the parameters.
      $params = array_merge( $params, $files );
    }

    $query = http_build_query( $params );
    $ch    = curl_init();
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch, CURLOPT_HEADER, false );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_POST, true );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $query );
    $response[ 'content' ] = curl_exec( $ch );
    $response[ 'header' ]  = curl_getinfo( $ch );
    curl_close( $ch );
    return $response;
  }

  /**
   * Formula to make any HTTP-POST requests.
   * @param       $url
   * @param       array $params
   * @param       array $headers
   * @param       string $method The method type in string. (PUT,DELETE,PATCH etc...)
   * @return      HTTP-Response body or an empty string if the request fails or is empty
   */
  private function makeRequestsFormula( $url, $params = [], $method, $headers = [], $files = [] ) {

    // Check if we have any files.
    if ( ! empty( $files ) ) {
      // Prepare array of the files path.
      foreach ( $files as $key => $file ) {
        $files[ $key ] = '@' . __DIR__ . '/../../' . trim( $files[ $key ], '/' );
      }
      // Merge files with the parameters.
      $params = array_merge( $params, $files );
    }

    $query = http_build_query( $params );
    $ch    = curl_init();
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch, CURLOPT_HEADER, false );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, $method );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $query );
    $response[ 'content' ] = curl_exec( $ch );
    $response[ 'header' ]  = curl_getinfo( $ch );
    curl_close( $ch );
    return $response;
  }

  /**
   * Make HTTP-PUT call
   * @param       $url
   * @param       array $params
   * @param       array $headers
   * @return      HTTP-Response body or an empty string if the request fails or is empty
   */
  public function HTTPPut( $url, $params = [], $headers = [], $files = [] ) {
    return $this->makeRequestsFormula( $url, $params, 'PUT', $headers, $files );
  }

  /**
   * Make HTTP-DELETE call
   * @param       $url
   * @param       array $params
   * @param       array $headers
   * @return      HTTP-Response body or an empty string if the request fails or is empty
   */
  public function HTTPDelete( $url, $params = [], $headers = [], $files = [] ) {
    return $this->makeRequestsFormula( $url, $params, 'DELETE', $headers, $files );
  }

  /**
   * Make HTTP-COPY call
   * @param       $url
   * @param       array $params
   * @param       array $headers
   * @return      HTTP-Response body or an empty string if the request fails or is empty
   */
  public function HTTPCopy( $url, $params = [], $headers = [], $files = [] ) {
    return $this->makeRequestsFormula( $url, $params, 'COPY', $headers, $files );
  }

  /**
   * Make HTTP-OPTIONS call
   * @param       $url
   * @param       array $params
   * @param       array $headers
   * @return      HTTP-Response body or an empty string if the request fails or is empty
   */
  public function HTTPOptions( $url, $params = [], $headers = [], $files = [] ) {
    return $this->makeRequestsFormula( $url, $params, 'OPTIONS', $headers, $files );
  }

  /**
   * Make HTTP-PATCH call
   * @param       $url
   * @param       array $params
   * @param       array $headers
   * @return      HTTP-Response body or an empty string if the request fails or is empty
   */
  public function HTTPPatch( $url, $params = [], $headers = [], $files = [] ) {
    return $this->makeRequestsFormula( $url, $params, 'PATCH', $headers, $files );
  }

  /**
   * Make HTTP-PROPFIND call
   * @param       $url
   * @param       array $params
   * @param       array $headers
   * @return      HTTP-Response body or an empty string if the request fails or is empty
   */
  public function HTTPPropfind( $url, $params = [], $headers = [], $files = [] ) {
    return $this->makeRequestsFormula( $url, $params, 'PROPFIND', $headers, $files );
  }

}
