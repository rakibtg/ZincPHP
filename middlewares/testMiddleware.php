<?php

  function testMiddleware() {
    // \App::response()
    //   ->data(['message' => 'Please login!'])
    //   ->send();
    \App::input()->merge(['name' => 'Confused Einestien']);
  }