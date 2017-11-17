<?php

  /**
   * A sample welcome page.
   * Learn more about blocks in the documentation.
   * @link http://...
   */

  // Welcome message data.
  $welcomeMessage = [
    'ZincPHP'   => 'Welcome to ZincPHP',
    'ToDo'      => 'To change this page, edit \'index.php\' inside \'blocks\' directory',
  ];

  \zp\output( $data = $welcomeMessage, $responseStatus = 200, $prettyPrint = true );