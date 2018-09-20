<?php

  trait ResponseTraits {

    public static function response() {
      return new ZincPHP\Response\ZincResponse();
    }

  }