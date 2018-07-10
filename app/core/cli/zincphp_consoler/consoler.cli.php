<?php
  set_time_limit(0);

  require_once __DIR__ . '/Console.php';
  $consoler = new Console();

  echo \ZincPHP\CLI\Helper\success( "ZincPHP Consoler is looking for logs" );
  echo \ZincPHP\CLI\Helper\nl();
  echo \ZincPHP\CLI\Helper\warn( "Press Ctrl + C to stop consoler." );
  echo \ZincPHP\CLI\Helper\nl();
  echo '_______________________________________';
  echo \ZincPHP\CLI\Helper\nl();
  echo \ZincPHP\CLI\Helper\nl();

  while( true ) {
    $consoler->reader();
    sleep( 1 );
  }

  exit();
