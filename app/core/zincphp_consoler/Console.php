<?php

  class Console {

    public function log(  ) {

    }

    public function reader() {
      $data = '';
      $_type = gettype( $data );
      if ( $_type === 'boolean' ) {
        if ( $data === true ) echo 'true';
        else echo 'false';
      } else if ( $_type === 'array' OR $_type === 'object' ) {
        print_r( $data );
      } else {
        echo $data;
      }
    }

  }