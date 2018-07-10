<?php

  use \ZincPHP\CLI\Helper as CLI;
  set_time_limit(0);

  require_once __DIR__ . '/Console.php';
  $consoler = new Console();

  echo CLI\success( "ZincPHP Consoler is looking for logs" );
  echo CLI\nl();
  echo CLI\warn( "Press Ctrl + C to stop consoler." );
  echo CLI\nl();
  echo '_______________________________________';
  echo CLI\nl();
  echo CLI\nl();

  while( true ) {
    $consoler->reader();
    sleep( 1 );
  }

  exit();
