<?php

  /**
   * A sample greeting block.
   * 
   * @link https://getzincphp.github.io/docs/latest/Blocks
   */

  $x = \App::db(false, true);
  $x->bootEloquent();

  $users = \App::model( 'v1/User' );
  $greetings = [
    'greetings' => 'Working on models to work in ZincPHP! 😍',
    'model' => $users->paginate(20)
  ];

  \App::response()
    ->data( $greetings )
    ->pretty()
    ->send();