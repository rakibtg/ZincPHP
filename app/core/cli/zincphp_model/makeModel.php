<?php
  
  use \ZincPHP\CLI\Helper as CLI;

  // Get all argument values as an associative array.
  $arguments = CLI\getArgumentVariables( $argv );

  // Model name.
  $modelName = \App::strTrim( $argv[2] );

  // Validate model name.
  if(empty($modelName)) {
    echo CLI\danger( '> Error: Model name can\'t be empty.' );
    CLI\nl();
    exit();
  }

  // checking for white-spaces
  if ( preg_match( '/\s/', $modelName ) ) {
    echo CLI\danger( '> Error: Model name should not have any white-spaces.' );
    CLI\nl();
    exit();
  }

  // Model file name with extension.
  $modelFileName = trim(pathinfo($modelName)['filename']);

  // Model directory.
  $modelDir = pathinfo($modelName)['dirname'];
  $modelDir = trim(($modelDir === '.' || $modelDir === '/') ? '' : $modelDir.'/');

  // Model file path.
  $modelFilePath = \App::dir('models') . '/' . $modelDir;

  // Model full path.
  $modelPath = $modelFilePath . $modelFileName . '.php';

  // Check if the model already exists or not.
  if ( file_exists( $modelPath ) ) {
    echo CLI\danger( "> Model file already exists." );
    CLI\nl();
    exit();
  }

  // Create model directories.
  if( ! file_exists( $modelFilePath ) ) {
    mkdir( $modelFilePath, 0777, true );
  }

  // Prepare the model template.
  $modelTemplate = file_get_contents(__DIR__.'/../zincphp_structures/model.php.example');

  // Update template definations.
  // .. add namespace of the model.
  if($modelDir === '/' || empty($modelDir)) {
    $modelNamespace = $modelFileName;
  } else {
    $_modelDir = ($modelDir[0] !== '/') ? $modelDir : substr($modelDir, 1);
    $modelNamespace = str_replace('/', '\\', $_modelDir).$modelFileName;
  }
  $modelTemplate = str_replace('{{ModelNamespace}}', $modelNamespace, $modelTemplate);

  // .. add class name.
  $modelTemplate = str_replace('{{ModelClass}}', $modelFileName, $modelTemplate);

  // .. if a custom table name was provided then add that.
  $modelCustomTableName = '';
  if(isset($arguments['table'])) {
    if(!empty($arguments['table'])) {
      $modelCustomTableName = 'protected $table = \''.trim($arguments['table']).'\';';
    }
  }
  $modelTemplate = str_replace('{{ModelTable}}', $modelCustomTableName, $modelTemplate);

  // Save the model.
  file_put_contents($modelPath, $modelTemplate);

  // Success.
  echo CLI\success( "✔ Model created successfully." );
  CLI\nl();
  echo "Path: " . $modelPath;
  CLI\nl();

  // Release the CLI 
  exit();