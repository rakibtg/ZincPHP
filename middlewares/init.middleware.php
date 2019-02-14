<?php

  $init = [
    'index/post' => [
      'testMiddleware'
    ],
    'api/v1/private' => [
      'isLoggedIn',
      'isConnectedPrivately'
    ]
  ];