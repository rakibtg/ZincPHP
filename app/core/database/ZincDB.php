<?php 

namespace ZincPHP\Database;
use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * ZincDB is a helper core class of ZincPHP framework that basically
 * makes a connection between the "Illuminate Database" package.
 * 
 */

class ZincDB {

  /**
   * Cache the instance.
   * 
   * @var object $instance
   */
  private static $instance = null;

  /**
   * Cache the query builder instance.
   * 
   * @var object $queryBuilder
   */
  private $queryBuilder = null;

  public static function getInstance() {
    if ( ! self::$instance ) self::$instance = new ZincDB();
    return self::$instance;
  }

  public function provider() {
    if ( ! $this->queryBuilder ) {

      $capsule = new Capsule;
      $capsule->addConnection( (array) \App::environment()->database_config );
      $capsule->setAsGlobal();

      // Pagination page resolver
      \Illuminate\Pagination\Paginator::currentPageResolver(function () {
        return (int) ( \App::input( 'page' ) ?? 1);
      });
      $this->queryBuilder = $capsule;

    }
    return $this->queryBuilder;
  }

}
