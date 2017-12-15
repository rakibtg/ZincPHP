<?php
  $env->secret_keys = bin2hex( random_bytes( 64 ) );
  file_put_contents( './app/environment.json', json_encode( $env, JSON_PRETTY_PRINT ) );
  echo "Secrent key has generated";
  \OutputCLI\nl();
  exit();