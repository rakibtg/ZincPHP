<?php
  namespace ZincPHP\Route;

  trait HandleBlockTraits {

    /**
     * Generate the namespace of the current block.
     * 
     * @param   none
     * @return  string  The block namespace.
     *
     */
    private function getBlockNamespace() {
      return '\\ZincPHP\\Blocks' 
        . str_replace('/', '\\', $this->segments)
        . '\\'
        . ucfirst($this->requestType)
        . ucfirst($this->blockLabel);
    }

    /**
     * Load a block class and then instantiate it.
     * This will also maintain the lif-cycle 
     * of the block.
     * 
     * @return  void
     */

    public function handleBlock() {
      $_blockNamespace = $this->getBlockNamespace();
      require_once $this->blockAbsolutePath;
      $blockObject = new $_blockNamespace();

      // Handle middleware for this block.
      $this->handleMiddleware(
        $blockObject->middleware()
      );

      // Mount the onMount life cycle class of the block.
      try {
        $blockObject->onMount();
      } catch (Exception $e) {
        \App::exception( $e );
      }      

      $this->handleValidation(
        $blockObject->validation()
      );

      $this->handleLibraries(
        $blockObject->library()
      );

      $blockObject->response()->send();

      // Mount the onUnMount life cycle class of the block.
      try {
        $blockObject->onUnMount();
      } catch (Exception $e) {
        \App::exception( $e );
      }
    }

    /**
     * Go to the block based on its request type.
     *
     * @param     none
     * @return    none
     */
    public function goToCurrentBlock() {
      if( file_exists( $this->blockAbsolutePath ) ) {
        $this->handleBlock();
      } else {
        // No block was found!
        \App::response()
          ->data( 'Block not found.' )
          ->error()
          ->pretty()
          ->send();
      }
    }

  }