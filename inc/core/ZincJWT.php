<?php

  /**
   * JWT Validation Helper Class of ZincPHP
   * Encodes and Decodes JWT token for authentication.
   * 
   * @author  Hasan <rakibtg@gmail.com>
   * @link https://github.com/rakibtg/ZincPHP
   */

  require_once './__JWT__/JWT.php';

  use \Firebase\JWT\JWT;

  class ZincJWT {

    /**
     * Converts and signs a PHP object or array into a JWT string.
     *
     * @param object|array  $payload    PHP object or array
     * @param string        $key        The secret key.
     *                                  If the algorithm used is asymmetric, this is the private key
     * @param string        $returnType What to return on a fail attempt.
     *                                  Supported returnables are 'boolean', 'error'
     * @param string        $alg        The signing algorithm.
     *                                  Supported algorithms are 'HS256', 'HS384', 'HS512' and 'RS256'
     * @param mixed         $keyId
     * @param array         $head       An array with header elements to attach
     *
     * @return string A signed JWT
     *
     * @uses jsonEncode
     * @uses urlsafeB64Encode
     */
    public function makeToken( $payload, $key, $returnType = 'boolean', $alg = 'HS256', $keyId = null, $head = null ) {
      try {
        return JWT::encode( $payload, $key, $alg = 'HS256', $keyId = null, $head = null );
      } catch( Exception $e ) {
        if( $returnType == 'boolean' ) return false;
        else if( $returnType == 'error' ) return $e;
        else return false;
      }
    }

    public function getToken() {
      // Get token from Authorization Header.
      // Check validity and return.
      /*
  try {
    $decoded = JWT::decode( $jwt, $key, [ 'HS256' ] );
  } catch( Exception $e ) {
    echo '<pre>';
    echo 'Ops! Failed to authenticate.';
    echo '</pre>';
    exit();
  }
      */
    }

  }