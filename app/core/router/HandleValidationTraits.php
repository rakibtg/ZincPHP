<?php
  namespace ZincPHP\Route;

  trait HandleValidationTraits {

    /**
     * Handle validations from the validation life cycle of a block.
     * 
     * @param   array   $rules  List of rules as an array.
     * @return  void|boolean
     */
    public function handleValidation($rules) {
      $rules = (array) $rules;
      if( !empty($rules) ) \App::validate($rules);
    }

  }