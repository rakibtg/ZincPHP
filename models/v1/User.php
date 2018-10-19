<?php

  class User extends ZincModel {
    public function posts() {
      return $this->hasMany( \App::model('v1/Post'), 'author' );
    }
  }