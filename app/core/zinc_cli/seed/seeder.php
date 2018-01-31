<?php

  require_once './app/core/zinc_dbm/ZincDBManager.php';

  ( new ZincDBManager() )->seed( $argv );