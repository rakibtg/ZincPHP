<?php

  namespace ZincPHP\Console;
  use \ZincPHP\CLI\Helper as CLI;

  class Console {

    /**
     * Creates a log file into the temporary_logs directory.
     *
     * @param   string $title Title of the log message
     * @param   any    $data  The data needed to be logged
     * @return  void
     */
    public function log ( $title = '', $data = '________$ZINCPHP$________' ) {
      // Find the content
      if ( $data === '________$ZINCPHP$________' ) {
        $data   = $title;
        $title  = '';
      }
      // Loggable data.
      $logs = [
        'logged_at'   => date( 'g:i:s A', time() ),
        'logged_data' => '',
        'data_type'   => gettype( $data ),
        'log_title'   => $title,
      ];
      // Process loggable data.
      if ( $logs[ 'data_type' ] === 'boolean' ) {
        $logs[ 'logged_data' ] = $data === true ? 'true' : 'false';
      } else if ( $logs[ 'data_type' ] === 'array' OR $logs[ 'data_type' ] === 'object' ) {
        $logs[ 'logged_data' ] = $data;
      } else if ( $logs[ 'data_type' ] === 'NULL' ) {
        $logs[ 'logged_data' ] = 'NULL';
      } else {
        $logs[ 'logged_data' ] = ( string ) $data;
      }
      // Make temporary log file.
      file_put_contents( __DIR__ . '/temporary_logs/' . time() . mt_rand( 99, 99999 ) . '.log', json_encode( $logs ) );
    }

    /**
     * Read logs live.
     * 
     * @return void
     */
    public function reader () {
      $logs = glob( __DIR__ . '/temporary_logs/*.log' );
      usort( $logs, function ( $a, $b ) {
        return filemtime( $a ) > filemtime( $b );
      } );
      foreach( $logs as $logFile ) {
        $log = json_decode( file_get_contents( $logFile ) );
        if ( ! empty( $log->log_title ) ) {
          echo CLI\success( trim( '➜ ' . trim( $log->log_title ) ) );
          echo '| ';
        } else {
          echo CLI\success( '➜' );
        }
        echo CLI\warn( $log->logged_at );
        echo '| ';
        echo CLI\danger( $log->data_type );
        echo CLI\nl();
        if ( $log->data_type === 'boolean' ) {
          if ( $log->logged_data === true ) echo 'true';
          else echo 'false';
        } else if ( $log->data_type === 'array' ) {
          print_r( ( array ) $log->logged_data );
        } else if ( $log->data_type === 'object' ) {
          print_r( ( object ) $log->logged_data );
        } else {
          echo $log->logged_data;
        }
        echo CLI\nl();
        // Delete the log file.
        unlink( $logFile );
      }
    }

  }
