<?php

  /**
   * Handle all input data in the block.
   *
   */

   class ZincPHPInput {

     public function input ( $fieldName = false ) {
       $method = App::requestType();
       return App::$method( $fieldName );
     }

   }
