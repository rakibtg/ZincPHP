<?php

  $responses = [];
  $g = \App::makeRequest()->HTTPCopy( 'http://127.0.0.1:2080/test-make-request', [] );
  $responses[] = $g;

  $g = \App::makeRequest()->HTTPDelete( 'http://127.0.0.1:2080/test-make-request', [] );
  $responses[] = $g;

  $g = \App::makeRequest()->HTTPGet( 'http://127.0.0.1:2080/test-make-request' );
  $responses[] = $g;

  $g = \App::makeRequest()->HTTPOptions( 'http://127.0.0.1:2080/test-make-request', [] );
  $responses[] = $g;

  $g = \App::makeRequest()->HTTPPatch( 'http://127.0.0.1:2080/test-make-request', [] );
  $responses[] = $g;

  $g = \App::makeRequest()->HTTPPost( 'http://127.0.0.1:2080/test-make-request', [] );
  $responses[] = $g;

  $g = \App::makeRequest()->HTTPPropfind( 'http://127.0.0.1:2080/test-make-request', [] );
  $responses[] = $g;

  $g = \App::makeRequest()->HTTPPut( 'http://127.0.0.1:2080/test-make-request', [] );
  $responses[] = $g;

  \App::response()
    ->data( $responses )
    ->send();