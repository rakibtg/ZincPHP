<?php

  /**
   * A sample greeting block.
   * 
   * @link https://getzincphp.github.io/docs/latest/Blocks
   */

  $greetings = [
    'greetings' => 'Welcome to ZincPHP',
    'to_do' => 'To edit this response, go to \'get.index.php\' inside \'blocks\' directory'
  ];

  App::response()
    ->data( $greetings )
    ->pretty()
    ->send();