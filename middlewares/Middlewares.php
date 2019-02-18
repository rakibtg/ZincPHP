<?php
  namespace ZincPHP\Middlewares\Register;

  class Middlewares extends \ZincPHP\Middleware\ZincMiddleware {

    public function blocks() {
      $this->setBlock('index/post', 'testMiddleware');
      $this->setBlock('index/post', ['testMiddleware', 'tommatto']);
      // $this->setBlock('index/potato', 'potato');
    }

    public function groups() {
      $this->setGroup('index', ['tommatto', 'testMiddleware']);
      $this->setGroup('index', 'testMiddleware');
    }

  }