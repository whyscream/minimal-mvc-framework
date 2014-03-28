<?php

    namespace Mvc;

    /**
     * Basic model that can be populated using a JSON file.
     */
    class JsonModel extends \ArrayIterator implements \Iterator, \Countable {

        /**
         * Create a new model based on a JSON file.
         * @param string $json_file Path to a JSON file.
         */
        public function __construct($json_file) {
            $data = $this->parseJson($json_file);
            parent::__construct($data);
        }

        /**
         * Parse the JSON file and return the data as an array.
         * @param string $json_file Path to a JSON file.
         * @returns array The data that was extracted from the JSON file.
         */
        private function parseJson($json_file) {
            if (!file_exists($json_file) || !is_readable($json_file)) {
                throw new \InvalidArgumentException(sprintf(
                    "JSON file '%s' is unavailable", $json_file));
            }
            $json_data = file_get_contents($json_file);
            $data = json_decode($json_data);
            if (!is_array($data)) {
                $json_error = json_last_error_msg();
                throw new \UnexpectedValueException(sprintf(
                    "Error while decoding JSON file '%s': %s", $json_file, $json_error));
            }
            return $data;
        }
    }
