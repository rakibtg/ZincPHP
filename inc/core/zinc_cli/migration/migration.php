<?php
  require_once './inc/core/ZincDBM/ZincDBManager.php';
  require_once './inc/migrations/goodjob.php';
  $zincDBManager = new ZincDBManager();
  $g = new Migration( $zincDBManager );
  $g->up();
  exit(); // End cli execution.