<?php

  class Console {

    public function log ( $data = '' ) {
      // Loggable data.
      $logs = [
        'logged_at'   => date( 'g:i:s A', time() ),
        'logged_data' => '',
        'data_type'   => gettype( $data ),
      ];
      // Process loggable data.
      if ( $logs[ 'data_type' ] === 'boolean' ) {
        $logs[ 'logged_data' ] = $data === true ? 'true' : 'false';
      } else if ( $logs[ 'data_type' ] === 'array' OR $logs[ 'data_type' ] === 'object' ) {
        $logs[ 'logged_data' ] = $data;
      } else {
        $logs[ 'logged_data' ] = ( string ) $data;
      }
      // Make temporary log file.
      file_put_contents( __DIR__ . '/temporary_logs/' . time() . mt_rand( 99, 99999 ) . '.log', json_encode( $logs ) );
    }

    public function reader () {
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