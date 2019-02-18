<?php

  namespace ZincPHP\Blocks\index\post\nice\blah;

  class GetBlah extends \ZincPHP\block\ZincBlock {

    public function response() {
      return \App::response('hey nice, blah?');
    }

  }