<?php

  /**
   * Make a new block.
   * Check block name validity.
   *
   */

  // Check valid block name.
  if( ! isset( $argv[ 2 ] ) ) exit( 'No block was created' );
  $blockPath = trim( $argv[ 2 ] );
  if( empty( $blockPath ) )  exit( 'No block was created' );

  // Extract file name for the block.
  $blockName = makeBlockName( $blockPath );
  $blockPath = ltrim( $blockPath, '/' );

  // Defining the block path.
  $blockPath = joinpaths( getcwd(), 'blocks', $blockPath );

  // Make directories for the block path, if they dont exists.
  if( ! file_exists( $blockPath ) ) {
    mkdir( $blockPath, 0777, true );
  }

  // Should it create a resource(create block for all request types)
  if( in_array( '--all', $argv ) ) {
    // Create block for all requests types.
    // Make GET block
    makeBlock( $blockPath, $blockName, 'get' );
    // Make POST block
    makeBlock( $blockPath, $blockName, 'post' );
    // Make put block
    makeBlock( $blockPath, $blockName, 'put' );
    // Make delete block
    makeBlock( $blockPath, $blockName, 'delete' );
    exit();
  }

  $showError = true;

  if ( in_array( '--get', $argv ) ) {
    // Make GET block
    makeBlock( $blockPath, $blockName, 'get' );
    $showError = false;
  }
  if ( in_array( '--post', $argv ) ) {
    // Make post block
    makeBlock( $blockPath, $blockName, 'post' );
    $showError = false;
  }
  if ( in_array( '--put', $argv ) ) {
    // Make put block
    makeBlock( $blockPath, $blockName, 'put' );
    $showError = false;
  }
  if ( in_array( '--delete', $argv ) ) {
    // Make delete block
    makeBlock( $blockPath, $blockName, 'delete' );
    $showError = false;
  }

  if( $showError ) {
    echo \OuputCLI\danger( "> Error: To make a block please mention the request type" );
    \OuputCLI\nl();
    echo \OuputCLI\success( "> Available request types are: " );
    \OuputCLI\nl();
    echo "
      --get      Create block for get request
      --post     Create block for post request
      --put      Create block for put request
      --delete   Create block for delete request
      --all      Create a resource block
    ";
    \OuputCLI\nl();
    exit();
  } else {
    // All done, exit here.
    exit();
  }



  /**
   * Make block name from the user defined make:block argument value.
   *
   */
  function makeBlockName( $userDefinedBlockName ) {
    $blockName = basename( $userDefinedBlockName );
    $blockName = rtrim( $blockName, '.php' );
    return trim( $blockName );
  }

  /**
   * Create a block.
   *
   */
  function makeBlock( $blockPath, $blockName, $requestType ) {
    // Raw block name
    $rawBlockName = $blockName;
    // Add request type with the block name.
    $blockName = $requestType . '.' .$blockName . '.php';
    // Check if the block already exists.
    if( file_exists( joinpaths( $blockPath, $blockName ) ) ) {
      echo \OuputCLI\danger( "> " . $rawBlockName . ' block for "'.$requestType.'" request already exists!' );
      \OuputCLI\nl();
    } else {
      // Create the block.
      copy( './inc/core/structures/NewBlock', joinpaths( $blockPath, $blockName ) );
      echo \OuputCLI\success( "> " . $rawBlockName . ' block has created for "'.$requestType.'" request as ' . $blockName );
      \OuputCLI\nl();
    }
  }
