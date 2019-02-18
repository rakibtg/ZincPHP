<?php
  namespace ZincPHP\Route;

  trait HandleLibraryTraits {

    /**
     * Handle library imports for the "library" life cycle of a block.
     * 
     * @param   array   $libs  List of libraries.
     * @return  void
     */
    public function handleLibraries($libs) {
      $libs = (array) $libs;
      if(!empty($libs)) {
        $libs = array_unique($libs);
        foreach($libs as $lib) {
          try {
            \App::import($lib);
          } catch (\Exception $e) {
            \App::exception($e);
          }
        }
      }
    }

  }