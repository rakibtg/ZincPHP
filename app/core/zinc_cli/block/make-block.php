<?php

  /**
   * Make a new block.
   * Check block name validity.
   *
   */

  // Check valid block name.
  if( ! isset( $argv[ 2 ] ) ) {
    echo \OutputCLI\danger( "> Error: No block was created, please provide a block name and request type." );
    \OutputCLI\nl();
    exit();
  }
  $blockPath = trim( $argv[ 2 ] );
  if( empty( $blockPath ) ) {
    echo \OutputCLI\danger( "> Error: No block was created, please provide a block name and request type." );
    \OutputCLI\nl();
    exit();
  }

  // Extract file name for the block.
  $blockName = makeBlockName( $blockPath );
  $blockPath = ltrim( $blockPath, '/' );

  // Defining the block path.
  $blockPath = \OutputCLI\joinpaths( getcwd(), 'blocks', $blockPath );

  // Make directories for the block path, if they dont exists.
  if( ! file_exists( $blockPath ) ) {
    mkdir( $blockPath, 0777, true );
  }

  // A flag for error.
  $showError = true;

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
    $showError = false;
  }

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
  if ( in_array( '--patch', $argv ) ) {
    // Make patch block
    makeBlock( $blockPath, $blockName, 'patch' );
    $showError = false;
  }
  if ( in_array( '--copy', $argv ) ) {
    // Make copy block
    makeBlock( $blockPath, $blockName, 'copy' );
    $showError = false;
  }
  if ( in_array( '--options', $argv ) ) {
    // Make options block
    makeBlock( $blockPath, $blockName, 'options' );
    $showError = false;
  }
  if ( in_array( '--propfind', $argv ) ) {
    // Make propfind block
    makeBlock( $blockPath, $blockName, 'propfind' );
    $showError = false;
  }

  if( $showError ) {
    echo \OutputCLI\danger( "> Error: To make a block please mention the request type" );
    \OutputCLI\nl();
    echo \OutputCLI\success( "> Available request types are: " );
    \OutputCLI\nl();
    echo "
      --get       Creates a block that listens to get request
      --post      Creates a block that listens to post request
      --put       Creates a block that listens to put request
      --delete    Creates a block that listens to delete request
      --all       Creates a block that listens to all of the above requests

      Other block types:
      ------------------
      --patch     Creates a block that listens to patch request
      --copy      Creates a block that listens to copy request
      --options   Creates a block that listens to options request
      --propfind  Creates a block that listens to propfind request
    ";
    \OutputCLI\nl();
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
    if( file_exists( \OutputCLI\joinpaths( $blockPath, $blockName ) ) ) {
      echo \OutputCLI\danger( "> " . $rawBlockName . ' block for "'.$requestType.'" request already exists!' );
      \OutputCLI\nl();
    } else {
      // Create the block.
      copy( './app/core/zinc_structures/NewBlock', \OutputCLI\joinpaths( $blockPath, $blockName ) );
      echo \OutputCLI\success( "> " . $rawBlockName . ' block has created for "'.$requestType.'" request as ' . $blockName );
      \OutputCLI\nl();
    }
  }
