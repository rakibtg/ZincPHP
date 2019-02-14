<?php

  namespace ZincPHP\Blocks\index\post;

  class PostBlock {

    public function onMount()
    {
      echo 'from onMount';
    }

    public function onUnMount()
    {
      echo 'from onUnMount';
    }

    public function middleware()
    {
      echo 'from middleware';
    }

    public function validation()
    {
      echo 'from validation';
    }

    public function library()
    {
      echo 'from library';
    }

    public function response()
    {
      \App::response()->data( \App::input()->all() )->send();
    }
  }