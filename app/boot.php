<?php
    require_once "../app/core/Zinc.php";

    /**
     * Instantiating Zinc core class.
     * This will boot the framework, and will
     * add other core libraries like validator, jwt,
     * database query builder etc with each block to be served.
     * Dynamic routing will be handled from this class.
     *
     * @return void
     */
    $zinc = new Zinc();
