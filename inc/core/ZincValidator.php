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
        }
      } else {
        $this->setError( $fieldName, $this->dashedToCamelCase( $validateValue[ 1 ] ) . ' field not found to compare differences of {label}', $validateValue[ 0 ] );
      }
    }

    /**
     * Validate that a field was "accepted" (based on PHP's string evaluation rules)
     * This validation rule implies the field is "required"
     *
     */
    protected function validateAccepted( $fieldName, $validateValue, $value ) {
      if( ! empty( $field ) ) {
        $acceptable = array( 'yes', 'on', 1, '1', true );
        if( ! in_array( $value, $acceptable, true ) ) {
          $this->setError( $fieldName, '{label} need to be accepted', $validateValue[ 0 ] );
        }
      }
    }

    /**
     * Validate that a field is an array
     *
     */
    protected function validateArray( $fieldName, $validateValue, $value ) {
      if( ! empty( $field ) ) {
        if( ! is_array( $value ) ) $this->setError( $fieldName, '{label} need to be an array', $validateValue[ 0 ] );
      }
    }

    /**
     * Validate that a field is numeric
     *
     */
    protected function validateNumeric( $fieldName, $validateValue, $value ) {
      if( ! empty( $field ) ) {
        if( ! is_numeric( $value ) ) $this->setError( $fieldName, '{label} need to be a numeric value', $validateValue[ 0 ] );
      }
    }

    /**
     * Validate that a field is an integer
     *
     */
    protected function validateInteger( $fieldName, $validateValue, $value ) {
      if( ! empty( $field ) ) {
        if( ! preg_match( '/^-?([0-9])+$/i', $value ) ) $this->setError( $fieldName, '{label} need to be a integer value', $validateValue[ 0 ] );
      }
    }

    /**
     * Validate the length of a string
     *
     */
    protected function validateLength( $fieldName, $validateValue, $value ) {
      if( ! empty( $field ) ) {
        if( ! is_string( $value ) ) $this->setError( $fieldName, '{label} invalid length value', $validateValue[ 0 ] );
        if( strlen( $value ) != ( int ) $validateValue[ 1 ] ) {
          $this->setError( $fieldName, '{label} length need to be '. $validateValue[ 1 ] .' characters', $validateValue[ 0 ] );
        }
      }
    }

    /**
     * Validate the length of a string
     * 
     */
    protected function validateLengthBetween( $fieldName, $validateValue, $value ) {
      if( ! empty( $field ) ) {
        if( ! is_string( $value ) ) $this->setError( $fieldName, '{label} invalid length value', $validateValue[ 0 ] );
        $length = strlen( $value );
        if( ! ( $length >= ( int ) $validateValue[ 1 ] && $length <= ( int ) $validateValue[ 2 ] ) ) {
          $this->setError( 
            $fieldName, 
            '{label} length need to be in between of '. $validateValue[ 1 ] .' to '.$validateValue[ 2 ], 
            $validateValue[ 0 ] 
          );
        }
      }
    }

    /**
     * Validate the length of a string
     * 
     */
    protected function validateLengthMin( $fieldName, $validateValue, $value ) {
      if( ! empty( $field ) ) {
        if( strlen( $value ) < $validateValue[ 1 ] ) {
          $this->setError( 
            $fieldName, 
            '{label} must be a minimum length of ' . $validateValue[ 1 ] . ' characters', 
            $validateValue[ 0 ] 
          );
        }
      }
    }

    /**
     * Validate the length of a string
     * 
     */
    protected function validateLengthMax( $fieldName, $validateValue, $value ) {
      if( ! empty( $field ) ) {
        if( strlen( $value ) > $validateValue[ 1 ] ) {
          $this->setError( 
            $fieldName, 
            '{label} must be no more than ' . $validateValue[ 1 ] . ' characters', 
            $validateValue[ 0 ] 
          );
        }
      }
    }

    /**
     * Validate the value of a field is greater than a minimum value.
     * 
     */
    protected function validateMin( $fieldName, $validateValue, $value ) {
      if( ! empty( $field ) ) {
        if ( ! is_numeric( $value ) ) { 
          $this->setError( 
            $fieldName, 
            '{label} must be numeric value', 
            $validateValue[ 0 ] 
          );
        } else {
          if( $validateValue[ 1 ] <= $value ) {
            $this->setError( 
              $fieldName, 
              '{label} must be less than ' . $validateValue[ 1 ], 
              $validateValue[ 0 ] 
            );
          }
        }
      }
    }

    /**
     * Validate the size of a field is less than a maximum value
     * 
     */
    protected function validateMax( $fieldName, $validateValue, $value ) {
      if( ! empty( $field ) ) {
        if ( ! is_numeric( $value ) ) { 
          $this->setError( 
            $fieldName, 
            '{label} must be numeric value', 
            $validateValue[ 0 ] 
          );
        } else {
          if( $validateValue[ 1 ] >= $value ) {
            $this->setError( 
              $fieldName, 
              '{label} must be greater than ' . $validateValue[ 1 ], 
              $validateValue[ 0 ] 
            );
          }
        }
      }
    }

    /**
     * Validate the size of a field is between min and max values
     * 
     */
    protected function validateBetween( $fieldName, $validateValue, $value ) {
      if( ! empty( $field ) ) {
        if ( ! is_numeric( $value ) ) { 
          $this->setError( 
            $fieldName, 
            '{label} must be numeric value', 
            $validateValue[ 0 ] 
          );
        } else {
          if( ! ( $value >= ( int ) $validateValue[ 1 ] && $value <= ( int ) $validateValue[ 2 ] ) ) {
            $this->setError( 
              $fieldName, 
              '{label} must be between ' . $validateValue[ 1 ] . ' and ' . $validateValue[ 2 ], 
              $validateValue[ 0 ] 
            );
          }
        }
      }
    }

    /**
     * Validate a field is contained within a list of values
     * 
     */
    protected function validateIn( $fieldName, $validateValue, $value ) {
      array_splice( $validateValue, 0, 1 );
      if( ! in_array( $value, $validateValue ) ) {
        $this->setError( 
          $fieldName, 
          '{label} contains invalid value', 
          $validateValue[ 0 ] 
        );
      }
    }

    /**
     * Validate a field is not contained within a list of values
     * 
     */
    protected function validateNotIn( $fieldName, $validateValue, $value ) {
      array_splice( $validateValue, 0, 1 );
      if( in_array( $value, $validateValue ) ) {
        $this->setError( 
          $fieldName, 
          '{label} contains invalid value', 
          $validateValue[ 0 ] 
        );
      }
    }

    /**
     * Validate a field contains a given string
     * 
     */
    protected function __contains( $fieldName, $validateValue, $value ) {
      $isContains = false;
      if ( function_exists( 'mb_strpos' ) ) {
        $isContains = mb_strpos( $value, $validateValue[ 1 ] ) !== false;
      } else {
        $isContains = strpos($value, $validateValue[ 1 ] ) !== false;
      }
      return $isContains;
    }

    protected function validateContains( $fieldName, $validateValue, $value ) {
      if( ! $this->__contains( $fieldName, $validateValue, $value ) ) {
        $this->setError( 
          $fieldName, 
          '{label} must contain ' . $validateValue[ 1 ], 
          $validateValue[ 0 ] 
        );
      }
    }

    protected function validateNotContains( $fieldName, $validateValue, $value ) {
      if( $this->__contains( $fieldName, $validateValue, $value ) ) {
        $this->setError( 
          $fieldName, 
          '{label} can\'t contain ' . $validateValue[ 1 ], 
          $validateValue[ 0 ] 
        );
      }
    }

    /**
     * Validate that a field is a valid IP address
     * 
     */
    protected function validateIp( $fieldName, $validateValue, $value )
    {
      if( ! empty( $value ) ) {
        if( filter_var($value, \FILTER_VALIDATE_IP) === false ) {
          $this->setError( 
            $fieldName, 
            $value.' is not a valid IP address',
            $validateValue[ 0 ] 
          );
        }
      }
    }

    /**
     * Validate that a field is a valid e-mail address
     * 
     */
    protected function validateEmail( $fieldName, $validateValue, $value ) {
      if( ! empty( $value ) ) {
        if( filter_var($value, \FILTER_VALIDATE_EMAIL) === false ) {
          $this->setError( 
            $fieldName, 
            $value.' is not a valid email address',
            $validateValue[ 0 ] 
          );
        }
      }
    }

    /**
     * Validate that a field is a valid URL by syntax
     * 
     */
    protected function validateUrl( $fieldName, $validateValue, $value ) {
      if( ! empty( $value ) ) {
        $validURL = false;
        $urlPrefixes = [ 'http://', 'https://', 'ftp://' ];
        foreach ( $urlPrefixes as $prefix ) {
          if (strpos($value, $prefix) !== false) {
            $validURL = filter_var($value, \FILTER_VALIDATE_URL) != false;
          }
        }
        if( ! $validURL ) {
          $this->setError( 
            $fieldName, 
            $value.' is not a valid URL',
            $validateValue[ 0 ] 
          );
        }
      }
    }

    /**
     * Validate that a field contains only alphabetic characters
     * 
     */
    protected function validateAlpha( $fieldName, $validateValue, $value ) {
      if( ! empty( $value ) ) {
        if( ! preg_match( '/^([a-z])+$/i', $value ) ) {
          $this->setError( 
            $fieldName, 
            '{label} should contain only alphabetic characters',
            $validateValue[ 0 ] 
          );
        }
      }
    }

    /**
     * Validate that a field contains only alpha-numeric characters
     * 
     */
    protected function validateAlphaNum( $fieldName, $validateValue, $value ) {
      if( ! empty( $value ) ) {
        if( ! preg_match( '/^([a-z0-9])+$/i', $value ) ) {
          $this->setError( 
            $fieldName, 
            '{label} should contain only alpha-numeric characters',
            $validateValue[ 0 ] 
          );
        }
      }
    }

    /**
     * Validate that a field contains only alpha-numeric characters, dashes, and underscores
     * 
     */
    protected function validateSlug( $fieldName, $validateValue, $value ) {
      if( ! empty( $value ) ) {
        if( ! preg_match( '/^([-a-z0-9_-])+$/i', $value ) ) {
          $this->setError( 
            $fieldName, 
            '{label} should contain only alpha-numeric characters, dashes, and underscores',
            $validateValue[ 0 ] 
          );
        }
      }
    }

    /**
     * Validate that a field passes a regular expression check
     * 
     */
    protected function validateRegex( $fieldName, $validateValue, $value ) {
      if( ! empty( $value ) ) {
        if( ! preg_match( $validateValue[ 1 ], $value ) ) {
          $this->setError( 
            $fieldName, 
            '{label} contains invalid characters',
            $validateValue[ 0 ] 
          );
        }
      }
    }

    /**
     * Validate that a field is a valid date
     * 
     */
    protected function validateDate( $fieldName, $validateValue, $value ) {
      if( ! empty( $value ) ) {
        $isDate = false;
        if ( $value instanceof \DateTime ) {
            $isDate = true;
        } else {
            $isDate = strtotime( $value ) !== false;
        }
        if( ! $isDate ) {
          $this->setError( 
            $fieldName, 
            '{label} contains invalid date',
            $validateValue[ 0 ] 
          );
        }
      }
    }

    /**
     * Validate that a field matches a date format
     * 
     */
    protected function validateDateFormat( $fieldName, $validateValue, $value ) {
      if( ! empty( $value ) ) {
        $parsed = date_parse_from_format( $validateValue[ 1 ], $value );
        if( ! $parsed['error_count'] === 0 && $parsed['warning_count'] === 0 ) {
          $this->setError( 
            $fieldName, 
            '{label} contains invalid date',
            $validateValue[ 0 ] 
          );
        }
      }
    }

    /**
     * Validate that a field contains a boolean.
     * 
     */
    protected function validateBoolean( $fieldName, $validateValue, $value )
    {
      if( ! is_bool( $value ) ) {
        $this->setError( 
          $fieldName, 
          '{label} must be boolean',
          $validateValue[ 0 ] 
        );
      }
    }

  }