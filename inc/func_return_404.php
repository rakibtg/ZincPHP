<?php

    function return_404( $msg = false ) {
        http_response_code( 404 );
        if( ! $msg ) $msg = 'Nothing found, 404';
        echo json_encode([
            'status' => $msg,
        ]);
        exit();
    }