<?php

  namespace ZincPHP\CLI;
  require_once './app/core/zinc_cli/cli_helpers.php';

  // Check if we have the variable json doc.
  if( ! file_exists( './app/environment.json' ) ) {
    $env = false;
  } else {
    // Import data from environment json doc.
    $env = json_decode( file_get_contents('./app/environment.json' ) );
  }

  /**
   * Execute a CLI command.
   *
   * @param array $env  Array data of the environment.json document
   * @param array $argv System argument variable
   * @return void
   */
  function execute( $env, $argv ) {

    // The current action command.
    if( isset( $argv[ 1 ] ) ) $thisArg = strtolower( trim( $argv[ 1 ] ) );
    else $thisArg = '';

    // Create a new environment.json file.
    if( $thisArg == 'env:new' ) require_once './app/core/zinc_cli/env/new_env.php';

    // No environment file found.
    if( $env === false ) require_once './app/core/zinc_cli/env/no_env.php';

    // App need to be in local environment, in production below commands wont work.
    if ( strtolower( $env->environment ) !== 'local' ) exit( \ZincPHP\CLI\Helper\warn( "\nZincPHP CLI can't run when it is not in local environment\n\n" ) );

    // Serve as a local development server.
    if( $thisArg == 'serve' ) require_once './app/core/zinc_cli/dev_server/serve.php';

    // Generate a new secret token.
    if( $thisArg == 'key:generate' ) require_once './app/core/zinc_cli/key/key_generate.php';

    // Add a new domain to allow CORS
    if( $thisArg == 'cors:add' ) require_once './app/core/zinc_cli/cors/cors_add.php';

    // Zinc command to create a new block.
    if( $thisArg == 'make:block' ) require_once './app/core/zinc_cli/block/make-block.php';

    // Make a new migration file.
    if( $thisArg == 'make:migration' ) require_once './app/core/zinc_cli/migration/make_migration.php';

    // Migrate the database.
    if( $thisArg == 'migrate' || $thisArg == 'migrate:up' ) {
      require_once './app/core/zinc_cli/migration/migrate_up.php';
    }

    if( $thisArg == 'migrate:down' ) {
      if( isset( $argv[ 2 ] ) ) {
        // Migrate a single table.
        require_once './app/core/zinc_cli/migration/down/migrate_down_single.php';
      } else {
        // Migrate all tables.
        require_once './app/core/zinc_cli/migration/down/migrate_down_all.php';
      }
    }

    if ( $thisArg === 'migrate:refresh' ) require_once './app/core/zinc_cli/migration/MigrateRefresh.php';

    // Default ZincPHP CLI welcome message.
    require_once './app/core/zinc_cli/static/default_message.php';
    
  }
