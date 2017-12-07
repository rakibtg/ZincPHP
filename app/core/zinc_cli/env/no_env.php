<?php

echo \OuputCLI\danger( "ERROR" ) . "No environment document was found!";
\OuputCLI\nl();
echo \OuputCLI\warn( "TIPS " )."Run this command ".\OuputCLI\success( 'php zinc env:new' )."to generate a new env file.";
\OuputCLI\nl();
exit();