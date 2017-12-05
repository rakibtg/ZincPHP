<?php
  namespace OuputCLI;
  /**
   * Outputs danger.
   */
  function danger( $msg ) {
    if( PHP_OS != 'WINNT'  ) {
      return "\033[31m$msg \033[0m";
    } else {
      return $msg;
    }
  }

  /**
   * Output success.
   */
  function success( $msg ) {
    if( PHP_OS != 'WINNT'  ) {
      return "\033[32m$msg \033[0m";
    } else {
      return $msg;
    }
  }

  /**
   * Output warning.
   */
  function warn( $msg ) {
    if( PHP_OS != 'WINNT'  ) {
      return "\033[33m$msg \033[0m";
    } else {
      return $msg;
    }
  }

  /**
   * New line; Helpful for those who using ZSH.
   */
  function nl() {
    echo "\n";
  }
