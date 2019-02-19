<?php
  
  use \ZincPHP\CLI\Helper as CLI;

  $env->secret_keys = \App::randomString( 100 );
  file_put_contents( \App::dir('environment.json'), json_encode( $env, JSON_PRETTY_PRINT ) );
  echo "Secrent key has generated";
  
  CLI\nl();
  exit();