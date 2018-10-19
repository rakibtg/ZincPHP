<?php

  // Sending a response back to client.
  \App::response()
    ->data(['name' => 'Hello World!', 'files' => $_FILES ])
    ->send();
