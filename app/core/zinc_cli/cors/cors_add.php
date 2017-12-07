<?php
  echo "\nAdding a new domain to allowed CORS list.\nType the domain name here (Example: 127.0.0.1:2010 or example.com - no http://)\n> ";
  $handle = fopen( "php://stdin", "r" );
  $domain = trim( fgets( $handle ) );
  if( ! empty( $domain ) ) {
    $env->cors_allowed[] = 'http://' . $domain;
    file_put_contents( './app/environment.json', json_encode( $env, JSON_PRETTY_PRINT ) );
    echo "\nDomain( " . $domain . " ) was added to allowed CORS list.\n\n";
  } else {
    echo "\nUnable to add a domain to allowed CORS list.\n\n";
  }
  exit();