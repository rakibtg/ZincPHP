<?php

  namespace ZincPHP\String;
  use Stringy\Stringy as S;

  class ZincString {
    public static function create( $string = '' ) {
      return S::create( $string );
    }
  }