<?php

  trait ResponseTraits {

    /**
     * Converts data to json then print it.
     *
     * @param array|object|string   $data           Data to output
     * @param integer               $responseStatus Set the response status code
     * @param boolean               $prettyPrint    Pretty prints the output JSON
     * @return void
     */
    public static function response( $data = [], $responseStatus = 200, $prettyPrint = false ) {

      // Setting the reponse code of the output.
      http_response_code( $responseStatus );

      if( empty( $data ) ) {
          echo json_encode( [] );
      } else if ( is_array( $data ) ) {
          if( $prettyPrint ) echo json_encode( $data, JSON_PRETTY_PRINT );
          else echo json_encode( $data );
      } else {
          echo json_encode( [ $data ] );
      }
      exit();
    }

    /**
     * Returns error with custom status response.
     * If a error message was not provided then the default
     * error message will be printed.
     *
     * @param   string    $msg        Custom error message
     * @param   integer   $status     HTTP status code, defualt is 404 (Not found)
     * @return  void
     */
    public static function responseError( $msg = false, $status = 404 ) {
        http_response_code( $status );
        if( ! $msg ) $msg = 'Unexpected error occured';
        echo json_encode( [
            'status' => $msg,
        ] );
        exit();
    }

  }