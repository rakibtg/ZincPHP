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
     * Token payloads.
     * 
     * @var bool $jwt_payloads
     */
    protected $jwt_payloads;

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

    function __construct() {
      // Reset the default values.
      $this->jwt_payloads   = [];
      $this->jwt_algorithm  = 'HS256';
      $this->jwt_claims     = [];
      $this->jwt_privateKey = \App::environment()->secret_keys;
    }

    /**
     * Method to add payloads for a new token.
     * 
     * @param   array  $payloads  The payloads need to be added with the token.
     * @return  object ...        Current object.
     */
    public function setPayloads( array $payloads = [] ) {
      $this->jwt_payloads = $payloads;
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
     * Generate the token.
     * 
     * @param   void
     * @return  string  The JWT token.
     */
    public function generate() {
      return [
        'jwt_payloads' => $this->jwt_payloads,
        'jwt_algorithm' => $this->jwt_algorithm,
        'jwt_claims' => $this->jwt_claims,
        'jwt_privateKey' => $this->jwt_privateKey,
      ];
    }

  }
