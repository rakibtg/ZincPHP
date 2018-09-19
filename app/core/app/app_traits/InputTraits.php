<?php

  /*
    Collection of methods that handles everything
    related to sending requests.
  */

  trait InputTraits {

    /**
     * Get input data from the available request method.
     *
     * @param   string $field The filed name, if not given then return all data of the request.
     * @return  string Returns null if the key is not found by default.
     */
    public static function input( $field = false ) {
      $_input = \ZincPHP\Input\ZincInput::getInstance()->provider();
      if( $field ) return $_input->input( $field );
      else return $_input;
    }
    
  }
