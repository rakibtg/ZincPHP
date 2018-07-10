<?php

echo \ZincPHP\CLI\Helper\danger( "ERROR" ) . "No environment document was found!";
\ZincPHP\CLI\Helper\nl();
echo \ZincPHP\CLI\Helper\warn( "TIPS " )."Run this command ".\ZincPHP\CLI\Helper\success( 'php zinc env:new' )."to generate a new env file.";
\ZincPHP\CLI\Helper\nl();
exit();