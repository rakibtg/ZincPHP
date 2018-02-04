<?php
  
  parse_str(file_get_contents("php://input"),$putData);

  print_r( $putData );