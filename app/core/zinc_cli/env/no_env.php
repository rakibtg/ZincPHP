<?php

echo \OutputCLI\danger( "ERROR" ) . "No environment document was found!";
\OutputCLI\nl();
echo \OutputCLI\warn( "TIPS " )."Run this command ".\OutputCLI\success( 'php zinc env:new' )."to generate a new env file.";
\OutputCLI\nl();
exit();