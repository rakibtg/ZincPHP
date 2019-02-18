<?php

  namespace ZincPHP\Route; 

  trait HandleMiddlewareTraits {

    public function initializeMiddleware() {
      $middlewareLists = \App::dir('middlewares') 
        . '/' 
        . 'Middlewares.php';
      if(file_exists($middlewareLists)) {
        require_once $middlewareLists;
        $middlewares = new \ZincPHP\Middlewares\Register\Middlewares();
        $middlewares->blocks();
        $middlewares->groups();
        return [
          'blocks' => $middlewares->getBlocks(),
          'groups' => $middlewares->getGroups(),
        ];
      }
      return false;
    }

    public function handleMiddleware($assignedMiddleware = []) {
      $assignedMiddleware = (array) $assignedMiddleware;
      $currentBlock = (string) \App::string($this->segments)
        ->trim('/')
        ->trim();
      $init = (array) $this->initializeMiddleware();
      if(isset($init['blocks'][$currentBlock])) {
        $assignedMiddleware = array_merge($assignedMiddleware, $init['blocks'][$currentBlock]);
      }

      // Merge all middlewares for this block and from its group.
      if(!empty($init['groups'])) {
        foreach($init['groups'] as $key => $middleware) {
          $key = (string) \App::string($key)
            ->trim()
            ->trim('/')
            ->ensureRight('/');
          if(\App::string((string) \App::string($currentBlock)->ensureRight('/'))->startsWith($key)) {
            if(!empty($middleware)) {
              foreach($middleware as $m) {
                $assignedMiddleware[] = $m;
              }
            }
          }
        }
      }

      $assignedMiddleware = array_unique($assignedMiddleware);

      if(isset($init['blocks'][$currentBlock])) {
        foreach($init['blocks'][$currentBlock] as $middlewareFile) {
          // Include the middleware function.
          require_once \App::dir('middlewares') 
            . '/' 
            . $middlewareFile 
            . '.php';
          // Call the middleware function.
          ($middlewareFile)();
        }
      }
    }

  }