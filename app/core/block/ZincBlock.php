<?php

  namespace ZincPHP\block;

  class ZincBlock {

    public function onMount () {}

    public function onUnMount () {}

    public function middleware () {}

    public function validation () {}

    public function library () {}

    public function response () {
      return \App::response();
    }
  }