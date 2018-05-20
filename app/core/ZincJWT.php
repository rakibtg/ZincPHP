<?php

  /**
   * JWT Validation Helper Class of ZincPHP
   * Encodes and Decodes JWT token for authentication.
   * 
   * @author  Hasan <rakibtg@gmail.com>
   * @link https://github.com/rakibtg/ZincPHP
  */

  require_once '../app/core/zinc_jwt/JWT.php';

  use \Firebase\JWT\JWT;
  
  class ZincJWT {

    /**
     * Store the environment settings
     * 
     * @var array $env
     */
    private $env;

    /**
     * Boot the JWT class by storing the app environment.
     * 
     * @param   array $env Array that contains all the environment settings.
     * @return  void 
     */
    function __construct( $env ) {
      $this->env = $env;
    }

    /**
     * Converts and signs a PHP object or array into a JWT string.
     *
     * @param object|array  $payload            PHP object or array
     * @param string        $key                The secret key.
     *                                          If the algorithm used is asymmetric, this is the private key
     * @param string        $returnBoolOnFail   What to return on a fail attempt.
     * @param string        $alg                The signing algorithm.
     *                                          Supported algorithms are 'HS256', 'HS384', 'HS512' and 'RS256'
     * @param mixed         $keyId
     * @param array         $head               An array with header elements to attach
     *
     * @return string A signed JWT
     *
     * @uses jsonEncode
     * @uses urlsafeB64Encode
     */
    public function makeToken( $payload, $returnBoolOnFail = true, $alg = 'HS256', $keyId = null, $head = null ) {
      try {
        return JWT::encode( $payload, $this->env->secret_keys, $alg = 'HS256', $keyId = null, $head = null );
      } catch( Exception $e ) {
        if( $returnBoolOnFail == true ) return false;
        else if( $returnBoolOnFail == false ) App::response( [ 'Unable to generate the token' ], 401 );
        else return false;
      }
    }

    /**
     * Convert a valid token and return its payloads.
     * @param string          $tokenString        JWT token
     * @param boolean|array   $returnBoolOnFail   What type of data should return on a fail attempt.
     * @param array           $alg                Set of supported algorithms.
     * 
     * @return boolean|array|void
     */
    public function getToken( $tokenString = false, $returnBoolOnFail = true, $alg = [ 'HS256' ] ) {
      if( ! $tokenString ) {
        if( isset( getallheaders()[ 'Authorization' ] ) ) {
          $tokenString = getallheaders()[ 'Authorization' ];
        } else {
          if( $returnBoolOnFail == true ) return false;
          else if( $returnBoolOnFail == false ) App::response( [ 'Authorization token not found in the header.' ], 403 );
          else return false;
        }
      }
      try {
        $token = (array) JWT::decode( $tokenString, $this->env->secret_keys, $alg );
        if ( empty( $token ) ) {
          // Token was invalid.
          App::response( [ 'Invalid token found' ], 403 );
        } 
        return $token;
      } catch( Exception $e ) {
        if( $returnBoolOnFail == true ) return false;
        else if( $returnBoolOnFail == false ) App::response( [ 'Invalid token found' ], 403 );
        else return false;
      }

    }

  }