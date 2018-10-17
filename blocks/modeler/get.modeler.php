<?php

  /**
   * A sample greeting block.
   * 
   * @link https://getzincphp.github.io/docs/latest/Blocks
   */

  $users = \App::model( 'v1/User' );

  $greetings = [
    'greetings' => 'Working on models to work in ZincPHP! 😍',
    'model' => $users->paginate(20)
  ];
  /*
    $i1 = \App::model( 'v1/User' );
    $i1->name = uniqid();
    $i1->email = uniqid() . '@gmail.com';
    $i1->bio = uniqid();
    $i1->save();

    $i2 = \App::model( 'v1/User' );
    $i2->name = uniqid();
    $i2->email = uniqid() . '@gmail.com';
    $i2->bio = uniqid();
    $i2->save();

    $i3 = \App::model( 'v1/User' );
    $i3->name = uniqid();
    $i3->email = uniqid() . '@gmail.com';
    $i3->bio = uniqid();
    $i3->save();
  */
  \App::response()
    ->data( $greetings )
    ->pretty()
    ->send();