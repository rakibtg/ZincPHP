<?php

  /**
   * A sample welcome page.
   * Learn more about blocks in the documentation.
   * @link http://...
   */

  // Welcome message data.
  $welcomeMessage = [
    'ZincPHP'   => 'Welcome to ZincPHP',
    'ToDo'      => 'To change this page, edit \'get.index.php\' inside \'block\' directory',
  ];

  App::response( $data = $welcomeMessage, $responseStatus = 200, $prettyPrint = true );
