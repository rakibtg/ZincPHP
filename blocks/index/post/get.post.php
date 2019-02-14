<?php



  class GetX {
    function printEverything() {
      $inputs = \App::input()->all();

      \App::response()
        ->data($inputs)
        ->pretty()
        ->send();
    }
  }

  (new GetX())->printEverything();