<?php
  namespace ZincPHP\Blocks\index;

  class GetIndex extends \ZincPHP\block\ZincBlock {

    public function response() {
      $greetings = [
        'greetings' => 'Welcome to ZincPHP',
        'to_do' => 'To edit this response, go to `get.index.php` inside `blocks` directory'
      ];

      return \App::response($greetings)
        ->pretty();
    }
  }