<?php

    use Mvc\PdoModel;

    /**
     * Simple example of a custom Model class.
     *
     * When you know what data is in the Model, you can make custom changes
     * based on that extra knowledge.
     */
    class PiesModel extends PdoModel {

        const CM_IN_INCHES = 0.393701;

        /**
         * Set table to use, now that we have context.
         */
        public function __construct($dsn) {
            parent::__construct($dsn, 'pies');
        }

        /**
         * Convert result properties to logical datatypes, now that we have context.
         */
        public function current() {
            $data = parent::current();
            $data->diameter = intval($data->diameter);

            $inches = $data->diameter * $this::CM_IN_INCHES;
            $data->diameter_in_inches = round($inches, 1);

            return $data;
        }
    }
