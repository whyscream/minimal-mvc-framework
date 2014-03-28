<?php

    use Mvc\PdoModel;

    /**
     * Simple example of a custom Model class.
     *
     * This class is just for illustration purposes, it does nothing useful. In stead of:
     * @code
     *  $pies = new PiesModel($dsn);
     * @endcode
     * You could also have written:
     * @code
     *  $pies = new PdoModel($dsn, 'pies');
     * @endcode
     */
    class PiesModel extends PdoModel {

        public function __construct($dsn) {
            parent::__construct($dsn, 'pies');
        }

    }
