<?php

  function return_error( $msg = false, $status = 404 ) {
    http_response_code( $status );
    if( ! $msg ) $msg = 'Unexpected error occured';
    echo json_encode([
      'status' => $msg,
    ]);
    exit();
  }