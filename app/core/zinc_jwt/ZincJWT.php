<?php

  /**
   * JWT Validation Helper Class of ZincPHP
   * Encodes and Decodes JWT token for authentication.
   * 
   * Read the JWT white paper here: https://tools.ietf.org/html/rfc7519
   * 
   * @author  Hasan <rakibtg@gmail.com>
   * @link https://github.com/rakibtg/ZincPHP
  */

  namespace ZincPHP\core;
  use \Firebase\JWT\JWT;
  
  class ZincJWT {

    /**
     * An array that set token head elements.
     * 
     * @var string $jwt_head
     */
    protected $jwt_head;

    /**
     * Set token algorithm.
     * 
     * @var string $jwt_algorithm
     */
    protected $jwt_algorithm;

    /**
     * Set private key to encode and decode the token.
     * 
     * @var string $jwt_privateKey
     */
    protected $jwt_privateKey;

    /**
     * Set token claims.
     * 
     * @var string $jwt_claims
     */
    protected $jwt_claims;

    /**
     * Set token claims.
     * 
     * @var string $jwt_claims
     */
    protected $jwt_oepnSSL;

    /**
     * The JWT token.
     * 
     * @var string $jwt_token
     */
    protected $jwt_token;

    /**
     * Should return claims.
     * 
     * @var bool $jwt_return_claims
     */
    protected $jwt_return_claims;

    /**
     * Should trigger leeway
     * Source: http://self-issued.info/docs/draft-ietf-oauth-json-web-token.html#nbfDef
     * 
     * @var bool|int $jwt_leeway
     */
    protected $jwt_leeway;

    function __construct() {
      // Reset the default values.
      $this->jwt_head           = [];
      $this->jwt_algorithm      = 'HS256';
      $this->jwt_claims         = [];
      $this->jwt_privateKey     = \App::environment()->secret_keys;
      $this->jwt_oepnSSL        = false;
      $this->jwt_token          = false;
      $this->jwt_return_claims  = false;
      $this->jwt_leeway         = false;
    }

    /**
     * Method to add token head elements.
     * 
     * @param   array  $head  An array of token head elements.
     * @return  object ...    Current object.
     */
    public function setHead( array $head = [] ) {
      $this->jwt_head = $head;
      return $this;
    }

    /**
     * Method to add payloads for a new token.
     * 
     * @param   array  $payloads  The payloads need to be added with the token.
     * @return  object ...        Current object.
     */
    public function setPayloads( array $payloads = [] ) {
      $this->jwt_claims[ 'payloads' ] = $payloads;
      return $this;
    }

    /**
     * Method to add token expiry date.
     * 
     * @param  int      $expiry  The expiry in unix timestamp.
     * @return object   ...      Current object.
     */
    public function setExpiry( int $expiry = 0 ) {
      if ( $expiry != 0 ) {
        $this->jwt_claims[ 'exp' ] = $expiry;
      }
      return $this;
    }

    /**
     * Method to set the algorithm of choice.
     * 
     * @param   string  $algorithm  The algorithm name to be used to encode/decode the token. 
     *                              Default is 'HS256'.
     * @return  object  ...         Current object.
     */
    public function setAlgorithm( string $algorithm = 'HS256' ) {
      $this->jwt_algorithm = $algorithm;
      return $this;
    }

    /**
     * Set the private key.
     * 
     * @param   string  $key  The secret key to be used to encode/decode the token.
     * @return  object  ...   Current object.
     */
    public function setPrivateKey( string $key = '' ) {
      if ( $key != '' ) $this->jwt_privateKey = $key;
      return $this;
    }

    /**
     * Set the issued.
     * 
     * @param   
     * @return  
     */
    public function setClaims( string $label, string $claim ) {
      $this->jwt_claims[ $label ] = $claim;
      return $this;
    }

    /**
     * Set the RSS private and public token.
     * 
     * @param   string  $privateKey   The RSA PRIVATE KEY
     * @return 
     */
    public function setOpenSSLPrivateKey( string $privateKey ) {
      $this->jwt_oepnSSL[ 'privateKey' ] = $privateKey;
      return $this;
    }

    /**
     * Set the RSS private and public token.
     * 
     * @param
     * @return
     */
    public function setOpenSSLPublicKey( string $publicKey ) {
      $this->jwt_oepnSSL[ 'publicKey' ] = $publicKey;
      return $this;
    }



    /**
     * Generate the token.
     * 
     * @param   void
     * @return  string  The JWT token.
     */
    public function generate() {
      // return [
      //   'jwt_head'        => $this->jwt_head,
      //   'jwt_algorithm'   => $this->jwt_algorithm,
      //   'jwt_claims'      => $this->jwt_claims,
      //   'jwt_privateKey'  => $this->jwt_privateKey,
      //   'jwt_oepnSSL'     => $this->jwt_oepnSSL,
      // ]; 

      if ( $this->jwt_oepnSSL === false ) {
        return JWT::encode( 
          $this->jwt_claims, 
          $this->jwt_privateKey,
          $this->jwt_algorithm,
          null,
          $this->jwt_head
        );
      } else {
        if ( isset( $this->jwt_oepnSSL[ 'privateKey' ] ) ) {
          return JWT::encode( 
            $this->jwt_claims, 
            $this->jwt_oepnSSL[ 'privateKey' ], 
            $this->jwt_algorithm 
          );
        } else {
          throw new \Exception( 'Unable to get the private key, please use setOpenSSLPrivateKey()' );
          exit();
        }
      }

    }


    /**
     * Set the RSS private and public token.
     * 
     * @param
     * @return
     */
    public function setToken( string $token ) {
      $this->jwt_token = $token;
      return $this;
    }

    /**
     * Get all the claims including the payloads.
     * 
     * @return
     */
    public function getClaims() {
      $this->jwt_return_claims = true;
      return $this;
    }

    /**
     * Set leeway in seconds.
     * Source: http://self-issued.info/docs/draft-ietf-oauth-json-web-token.html#nbfDef
     * 
     * @param   int     $sec leeway in seconds.
     * @return  object  ...  Current object.
     */
    public function setLeeway( int $sec = 0 ) {
      if ( $sec > 0 ) {
        $this->jwt_leeway = $sec;
      }
      return $this;
    }

    /**
     * Method to set the list of allowed algorithm while decode.
     * 
     * @param   array    $algorithm  The list of algorithms name to be used to encode/decode the token. 
     *                               Default is 'HS256'.
     * @return  object  ...          Current object.
     */
    public function setAllowedAlgorithm( array $algorithm = [ 'HS256' ] ) {
      $this->jwt_algorithm = $algorithm;
      return $this;
    }

    /**
     * Decode and verify a JWT token.
     * 
     * @param
     * @return 
     */
    public function verify() {

      // Look for the JWT token
      if ( $this->jwt_token === false ) {
        // Token was not provided using setToken() method, checking in the header request.
        if( isset( getallheaders()[ 'Authorization' ] ) ) $this->jwt_token = getallheaders()[ 'Authorization' ];
      }
      // Check if token was found.
      if ( $this->jwt_token === false ) {
        throw new \Exception( 'Authorization token not found.' );
        exit();
      }
      
      // Leeway in seconds.
      if ( $this->jwt_leeway !== false ) JWT::$leeway = $this->jwt_leeway;

      $claims = ( array ) JWT::decode ( 
        $this->jwt_token, 
        $this->jwt_oepnSSL === false ? $this->jwt_privateKey : $this->jwt_oepnSSL[ 'publicKey' ],
        ( array ) $this->jwt_algorithm
      );
      if ( $this->jwt_return_claims ) {
        // Return payloads with claims.
        return $claims;
      } else {
        // Return only the payloads.
        return $claims[ 'payloads' ];
      }

    }

  }
