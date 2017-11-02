<?php

  /**
   * Validation Class of ZincPHP
   * Validates input against certain criteria
   * 
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
     * Array Example: $customErrors[ filedName ][ errorType ] = Error message.
     * String Example: $customErrors[ filedName ] = Error message.
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
     * Take input from block to process and validate an array of data.
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

          // Work with custom error messages.
          if( isset( $rules[ 'error' ] ) ) {
            $__ruleErrors = $rules[ 'error' ];
            if( ! empty( $__ruleErrors ) ) {
              if( $__ruleErrors ) {
                if( is_string( $__ruleErrors ) ) {
                  $this->customErrors[ $fieldName ] = $__ruleErrors;
                } else if ( is_array( $__ruleErrors ) ) {
                  foreach( $__ruleErrors as $_reIndex => $_reMsg ) {
                    $this->customErrors[ $fieldName ][ $_reIndex ] = $_reMsg;
                  }
                }
              }
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

      foreach( $this->validables as $fieldName => $validate ) {
        foreach( $validate[ 'rules' ] as $rule ) {
          $rule = explode( ':', $rule );
          $_callable = trim( 'validate' . ucfirst( $rule[ 0 ] ) ); // Preparing validate method name
          $this->$_callable( $fieldName, $rule, trim( $validate[ 'value' ] ) ); // Calling each validate method.
        }
      }
      
    print "+=====================+";
    // print_r($this->validables);
    print "+=====================+";
    print_r($this->errorMessageList);
    }

    /**
     * Set error messages to $this->errorMessageList.
     * 
     * @param string $fieldName
     * @param string $defaultMessage
     * @param string $validatorName
     */
    private function setError( $fieldName, $defaultMessage, $validatorName = false ) {
      $error = '';
      $fieldLabel = $this->dashedToCamelCase( $fieldName );
      // Check if we have a custom error message
      if( isset( $this->customErrors[ $fieldName ] ) ) {
        // We have a custom error message for this field.
        $_customMessage = $this->customErrors[ $fieldName ];
        if( is_string( $_customMessage ) ) {
          $error = trim( $_customMessage );
        } else if ( is_array( $_customMessage ) ) {
          if( isset( $_customMessage[ $validatorName ] ) ) {
            $error = trim( $_customMessage[ $validatorName ] );
          } else {
            $error = $defaultMessage;
          }
        }
      } else {
        $error = $defaultMessage;
      }
      $this->errorMessageList[ $fieldName ][] = str_replace( '{label}', $fieldLabel, $error );
    }

    /**
     * Converts a dashed-string to Dashed String :D
     * 
     */
    public function dashedToCamelCase( $str ) {
      return trim( str_replace( '_', ' ', ucwords( $str, '_' ) ) );
    }

    /**
     * Required field validator
     * 
     * Field Name: name <- $fieldName
     * Value: Kazi Mehedi Hasan <- $value
     * Array <- $validateValue
     * (
     *     [0] => max
     *     [1] => 50
     * )
     */
    public function validateRequired( $fieldName, $validateValue, $value ) {
      if( empty( $value ) ) {
        $this->setError( $fieldName, '{label} is required.', $validateValue[ 0 ] );
      }
    }

    /**
     * Validate that two values match
     *
     */
    protected function validateEquals( $fieldName, $validateValue, $value ) {
      if( $value != trim( $validateValue[ 1 ] ) ) {
        $this->errorMessageList[ $fieldName ][] = 'Not equal value';
      }
    }

    /**
     * Validate that a field is different from another field
     *
     */
    protected function validateDifferent( $fieldName, $validateValue, $value ) {
      if( isset( $this->validables[ trim( $validateValue[ 1 ] ) ][ 'value' ] ) ) {
        if( $value == $this->validables[ trim( $validateValue[ 1 ] ) ][ 'value' ] ) {
          $this->setError( $fieldName, '{label} and '. $this->dashedToCamelCase( $validateValue[ 1 ] ) .' can not be same.', $validateValue[ 0 ] );
          // $this->errorMessageList[ $fieldName ][] = 'Fields are not different';
        }
      } else {
        $this->setError( $fieldName, 'Can\'t compare {label} with '. $this->dashedToCamelCase( $validateValue[ 1 ] ), $validateValue[ 0 ] );
      }
    }

    /**
     * Validate that a field was "accepted" (based on PHP's string evaluation rules)
     * This validation rule implies the field is "required"
     *
     */
    protected function validateAccepted( $fieldName, $validateValue, $value ) {
      $acceptable = array( 'yes', 'on', 1, '1', true );
      if( ! in_array( $value, $acceptable, true ) ) {
        $this->setError( $fieldName, '{label} need to be accepted', $validateValue[ 0 ] );
      }
    }

    /**
     * Validate that a field is an array
     *
     */
    protected function validateArray( $fieldName, $validateValue, $value ) {
      if( ! is_array( $value ) ) $this->setError( $fieldName, '{label} need to be an array', $validateValue[ 0 ] );
    }

    /**
     * Validate that a field is numeric
     *
     */
    protected function validateNumeric( $fieldName, $validateValue, $value ) {
      if( ! is_numeric( $value ) ) $this->setError( $fieldName, '{label} need to be a numeric value', $validateValue[ 0 ] );
    }

    /**
     * Validate that a field is an integer
     *
     */
    protected function validateInteger( $fieldName, $validateValue, $value ) {
      if( ! preg_match( '/^-?([0-9])+$/i', $value ) ) $this->setError( $fieldName, '{label} need to be a integer value', $validateValue[ 0 ] );
    }

    /**
     * Validate the length of a string
     *
     */
    protected function validateLength( $fieldName, $validateValue, $value )
    {
      if( ! is_string( $value ) ) $this->setError( $fieldName, '{label} invalid length value', $validateValue[ 0 ] );
      if( strlen( $value ) != ( int ) $validateValue[ 1 ] ) {
        $this->setError( $fieldName, '{label} length need to be '. $validateValue[ 1 ] .' charecters', $validateValue[ 0 ] );
      }
    }











    public function validateMax( $fieldName, $validateValue, $value ) {
      // print "-----------------------\nFrom validateMax \n";
      // print "Field Name: " . $fieldName . "\n";
      // print "Value: " . $value . "\n";
      // print_r( $validateValue );
    }
    public function validateEmail( $fieldName, $validateValue, $value ) {
      // print "-----------------------\nFrom validateEmail \n";
      // print "Value: " . $value . "\n";
      // print_r( $validateValue );
    }

    public function validateUnique( $fieldName, $validateValue, $value ) {
      // print "-----------------------\nFrom validateUnique \n";
      // print "Value: " . $value . "\n";
      // print_r( $validateValue );
    }
  }