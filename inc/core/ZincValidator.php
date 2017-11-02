<?php

  /**
   * Validation Class of ZincPHP
   *
   * Validates input against certain criteria
   * Inspired by https://github.com/vlucas/valitron
   * @author  Hasan <rakibtg@gmail.com>
   * @link https://github.com/rakibtg/ZincPHP
   */

  class ZincValidator {

    /**
     * Contains  all the errors by their field name.
     * If  it is empty  then  there is   no  error  but,
     * if  it is not empty then there should  be some error.
     *
     * @var array
     */
    private $errorMessageList = [];

    /**
     * Contains all fields and their rules.
     *
     * @var array
     */
    private $validables = [];

    /**
     * Contains user  provided custom  error  messages.
     * If a custom   message was found  for a  field then the
     * custom error message will be used instead the defauly message.
     *
     * @var array
     */
    private $customErrors = [];

    /**
     * Determines from what type of request we should receive the data.
     * Default value is GET,  that means by default it would expect data from 
     * query string, if default value is given from the block, then this is optional.
     *
     * @var array
     */
    private $queryStringType = '';

    /**
     * Method to print errors and stop the script execution.
     * 
     */
    private function _returnError() {
      if( ! empty( $this->errorMessageList ) ) {
        http_response_code( 400 );
        echo json_encode( $this->errorMessageList );
        exit();
      }
    }

    /**
     * Take input to process and validate.
     * 
     * @param  array  $toValid
     */
    public function validate( $toValid = [], $queryStringType = 'get' ) {

      // Set query string.
      $_qs = trim( strtolower( $queryStringType ) );
      $this->queryStringType = $_qs;
      unset( $_qs );

      // Start validation process.
      if( ! empty( $toValid ) ) {
        foreach( $toValid as $fieldName => $rules ) {
          // Caching $rules type.
          $_type = gettype( $rules );
          if( $_type == 'string' ) {
            // Extract all rules and set them in the validables property
            $this->validables[ $fieldName ][ 'rules' ] = explode( '|', $rules );
          } else if ( $_type == 'array' ) {
            $this->validables[ $fieldName ][ 'rules' ] = explode( '|', $rules[ 'rules' ] );
          }
          // Set the value.
          // Checking if value has provided from block.
          if( isset( $rules[ 'value' ] ) ) {
            // Value found from block.
            $this->validables[ $fieldName ][ 'value' ] = $rules[ 'value' ];
          } else {
            // No value found from block.
            // Get data from requests aka user input.
            if( $this->queryStringType == 'get' ) {
              // Get user inputs from query string.
              $this->validables[ $fieldName ][ 'value' ] = _get( $fieldName );
            } else if ( $this->queryStringType == 'post' ) {
              // Get user inputs from post data.
              $this->validables[ $fieldName ][ 'value' ] = _post( $fieldName );
            }
            
          }
        }
      }

      // Start validating.
      $this->startValidating();

    }

    /**
     * Start validating the processed data from $validables
     * 
     * @return array
     */
    public function startValidating() {

      if( ! empty( $this->validables ) ) {
        $this->_returnError();
      }

      foreach( $this->validables as $validate ) {
        foreach( $validate[ 'rules' ] as $rule ) {
          $rule = explode( ':', $rule );
          $_callable = trim( 'validate' . ucfirst( $rule[ 0 ] ) ); // Preparing validate method name
          $this->$_callable( $rule, $validate[ 'value' ] ); // Calling each validate method.
        }
      }

    }

    /**
     * 
     * 
     */
    public function validateRequired( $validate, $value ) {
      print "-----------------------\nFrom validateRequired \n";
      print "Value: " . $value . "\n";
      print_r( $validate );
    }
    public function validateMax( $validate, $value ) {
      print "-----------------------\nFrom validateMax \n";
      print "Value: " . $value . "\n";
      print_r( $validate );
    }
    public function validateEmail( $validate, $value ) {
      print "-----------------------\nFrom validateEmail \n";
      print "Value: " . $value . "\n";
      print_r( $validate );
    }
    public function validateInteger( $validate, $value ) {
      print "-----------------------\nFrom validateInteger \n";
      print "Value: " . $value . "\n";
      print_r( $validate );
    }
    public function validateUnique( $validate, $value ) {
      print "-----------------------\nFrom validateUnique \n";
      print "Value: " . $value . "\n";
      print_r( $validate );
    }
  }