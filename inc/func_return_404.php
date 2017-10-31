<?php

    function return_404( $msg = false ) {
        header("HTTP/1.0 404 Not Found");
        if( ! $msg ) $msg = 'Nothing found, 404';
        echo json_encode([
            'status' => $msg,
        ]);
        exit();
    }