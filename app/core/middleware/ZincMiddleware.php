<?php
  namespace ZincPHP\Middleware;

  /**
   * This is the parent class of "middlewares/Middleware"
   * that will register middlewares to blocks.
   * 
   */

  class ZincMiddleware {

    protected $group = [];
    protected $block = [];

    protected function setMiddleware($entity, $middlewares, $type) {
      $middlewares = (array) $middlewares;
      foreach($middlewares as $middleware) {
        $middlewareName = (string) \App::string($middleware)
          ->trim(DIRECTORY_SEPARATOR)
          ->trim();
        
        if((string) \App::string($middlewareName)->ensureRight('.php') === 'Middlewares.php') {
          \App::exception(
            'Can not load Middlewares class as a middleware. 
              "Middlewares" is an invalid middleware.'
          );
        }

        $middlewareFilePath = (string) \App::dir('middlewares') 
          . DIRECTORY_SEPARATOR 
          . $middlewareName;

        $middlewareFilePath = \App::string($middlewareFilePath)->ensureRight('.php');

        // Check if middleware exists
        if(file_exists($middlewareFilePath)) {
          if($type === 'group') {
            !isset($this->group[$entity]) && $this->group[$entity] = [];
            !in_array($middlewareName, $this->group[$entity]) && $this->group[$entity][] = $middlewareName;
          } else if ($type === 'block') {
            !isset($this->block[$entity]) && $this->block[$entity] = [];
            !in_array($middlewareName, $this->block[$entity]) && $this->block[$entity][] = $middlewareName;
          }
        } else {
          \App::exception('Middleware not found at: ' . $middlewareFilePath);
        }

      }
    }

    public function setBlock($block, $middleware) {
      $this->setMiddleware($block, $middleware, 'block');
    }

    public function setGroup($group, $middleware) {
      $this->setMiddleware($group, $middleware, 'group');
    }

    public function getBlocks() {
      return $this->block;
    }

    public function getGroups() {
      return $this->group;
    }

    public function blocks() {
      return false;
    }

    public function groups() {
      return false;
    }

  }