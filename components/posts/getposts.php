<?php

    $table   = 'posts';
    $page = _get( 'page' );
    $limit = _get( 'limit' );

    if( $page == '' ) $page     = 1;
    if( $limit == '' ) $limit   = 20;

    echo $db->table( $table )->orderBy( 'id', 'DESC' )->paginate( $page, $limit )->toJSON();