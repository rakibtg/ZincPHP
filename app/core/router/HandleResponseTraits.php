<?php
  namespace ZincPHP\Route;

  trait HandleResponseTraits {

    public function handleResponse( $response ) {
      if( method_exists($response, 'send') ) {
        $response->send();
      } else {
        \App::exception('The response() method of the block should return a valid \App::response() object.');
      }
    }

  }