<?php 

/**
 * ZincDB is a helper core class of ZincPHP framework that basically
 * makes a connection between the pixie package.
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

  public function newQB() {
    if ( ! $this->queryBuilder ) {
      $zpEnv = (array) App::environment()->database_config;
      $connection = new \Pixie\Connection( $zpEnv[ 'driver' ], $zpEnv );
      $this->queryBuilder = new \Pixie\QueryBuilder\QueryBuilderHandler( $connection );
    }
    return $this->queryBuilder;
  }

}
