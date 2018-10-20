<?php

  namespace ZincPHP\CLI;
  require_once __DIR__ . '/../intellect/App.php';
  require_once __DIR__ . '/cli_helpers.php';

  $envPath = __DIR__ . '/../../environment.json';

  // Check if we have the variable json doc.
  if( ! file_exists( $envPath ) ) {
    $env = false;
  } else {
    // Import data from environment json doc.
    $env = json_decode( file_get_contents( $envPath ) );
  }

  /**
   * Execute a CLI command.
   *
   * @param   array $env  Array data of the environment.json document
   * @param   array $argv System argument variable
   * @return  void
   */
  function execute( $env, $argv ) {

    // The current action command.
    if( isset( $argv[ 1 ] ) ) $thisArg = strtolower( trim( $argv[ 1 ] ) );
    else $thisArg = '';

    // Create a new environment.json file.
    if( $thisArg == 'env:new' ) require_once './app/core/cli/env/new_env.php';

    // No environment file found.
    if( $env === false ) require_once './app/core/cli/env/no_env.php';

    // App need to be in local environment, in production below commands wont work.
    if ( strtolower( $env->environment ) !== 'local' ) exit( \ZincPHP\CLI\Helper\warn( "\nZincPHP CLI can't run when it is not in local environment\n\n" ) );

    // Serve as a local development server.
    if( $thisArg == 'serve' ) require_once './app/core/cli/dev_server/serve.php';

    // Generate a new secret token.
    if( $thisArg == 'key:generate' ) require_once './app/core/cli/key/key_generate.php';

    // Add a new domain to allow CORS
    if( $thisArg == 'cors:add' ) require_once './app/core/cli/cors/cors_add.php';

    // Zinc command to create a new block.
    if( $thisArg == 'make:block' ) require_once './app/core/cli/block/make-block.php';

    // Make a new migration file.
    if( $thisArg == 'make:migration' ) require_once './app/core/cli/migration/make_migration.php';

    // Migrate the database.
    if( $thisArg == 'migrate' || $thisArg == 'migrate:up' ) {
      require_once './app/core/cli/migration/migrate_up.php';
    }

    // Migrate down.
    if( $thisArg == 'migrate:down' ) {
      require_once './app/core/cli/migration/migrate_down.php';
    }

    // Clean the database and migrate again.
    if ( $thisArg === 'migrate:refresh' ) require_once './app/core/cli/migration/MigrateRefresh.php';

    if ( $thisArg === 'make:seed' ) require_once './app/core/cli/seed/make_seeder.php';

    if ( $thisArg === 'seeder' || $thisArg === 'seed' ) require_once './app/core/cli/seed/seeder.php';

    // Run test command.
    if ( $thisArg === 'run:test' ) require_once './app/core/cli/zincphp_tester/runTest.php';

    // Make a new library.
    if ( $thisArg === 'make:library' ) require_once './app/core/cli/zincphp_library/makeLibrary.php';

    // Live output console logs.
    if ( $thisArg === 'run:consoler' ) require_once './app/core/cli/zincphp_consoler/consoler.cli.php';

    // View environments details.
    if( $thisArg === 'env' ) require_once __DIR__ . '/env/env_view.php';

    // Create a new model file.
    if( $thisArg === 'make:model' ) require_once __DIR__ . '/zincphp_model/makeModel.php';

    // Default ZincPHP CLI welcome message.
    require_once './app/core/cli/static/default_message.php';

  }
