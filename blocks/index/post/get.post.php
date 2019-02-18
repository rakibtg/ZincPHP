<?php

  namespace ZincPHP\Blocks\index\post;

  class GetPost extends \ZincPHP\block\ZincBlock {

    public function onMount() {
      // This code will be executed before mounting this block.
    }

    public function onUnMount() {
      // This code will be executed at the end, before exiting the app.
    }

    public function middleware() {
      return [
        'tommatto'
      ];
    }

    public function validation() {
      return [
        'fullName'  => 'lengthMax:35',
        'userName'  => 'lengthMax:30',
        'email'     => 'lengthMax:60|email',
        'password'  => 'lengthBetween:8:100',
      ];
    }

    public function library() {
      return [
        'Greetings',
      ];
    }

    public function response() {
      \App::input()->merge([
        'ok' => (new \Greetings\Greetings())->hello()
      ]);
      $data = \App::input()->all();
      return \App::response($data)->pretty();
    }
  }