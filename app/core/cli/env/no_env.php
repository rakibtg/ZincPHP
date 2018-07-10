<?php

use \ZincPHP\CLI\Helper as CLI;

echo CLI\danger( "ERROR" ) . "No environment document was found!";

CLI\nl();

echo CLI\warn( "TIPS " ) 
  . "Run this command "
  . CLI\success( 'php zinc env:new' )
  . "to generate a new env file.";

CLI\nl();

// Exit from the CLI
exit();