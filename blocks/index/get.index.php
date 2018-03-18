<?php

  /**
   * A sample welcome block.
   * Learn more about blocks in the documentation.
   * @link http://...
   */

  // Welcome message data.
  $welcomeMessage = [
    'ZincPHP'   => 'Welcome to ZincPHP',
    'ToDo'      => 'To edit this response, go to \'get.index.php\' inside \'blocks\' directory',
    'yo'        => App::input( 'yo' ),
  ];
  App::console()->log( 'I am at line 15!' );
  App::response( $data = $welcomeMessage, $responseStatus = 200, $prettyPrint = true );
