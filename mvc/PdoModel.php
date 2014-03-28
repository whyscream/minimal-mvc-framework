<?php

    namespace Mvc;

    /**
     * Basic model that supports database backends using PDO.
     */
    class PdoModel extends \Pdo implements \Iterator, \Countable {

        private $table;
        private $statement;
        private $next_record;
        private $cursor = 0;

        /**
         * Create a new model and connect it to a database and table.
         */
        public function __construct($dsn, $table, $username=null, $password=null) {
            parent::__construct($dsn, $username, $password);
            $this->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->table = $table;
        }

        /**
         * Prepare query to return all records from the table.
         */
        private function getAllRecords() {
            $sql = sprintf("SELECT * from '%s'", $this->table);
            $this->statement = $this->prepare($sql);
            $this->statement->execute();
            $this->fetchNextRecord();
        }

        /**
         * Return the amount of records in the table.
         */
        private function getRecordCount() {
            $sql = sprintf("SELECT COUNT(1) FROM '%s'", $this->table);
            $stmt = $this->query($sql);
            return (int) $stmt->fetchColumn();
        }

        /**
         * Internal method to fetch the next record from the table.
         */
        private function fetchNextRecord() {
            $record = $this->statement->fetch(\PDO::FETCH_OBJ);
            $this->next_record = $record;
        }

        /**
         * Implementation of current() for the Iterator interface.
         */
        public function current() {
            if (is_null($this->next_record)) {
                $this->getAllRecords();
            }
            return $this->next_record;
        }

        /**
         * Implementation of key() for the Iterator interface.
         */
        public function key() {
            return $this->cursor;
        }

        /**
         * Implementation of next() for the Iterator interface.
         */
        public function next() {
            $this->cursor++;
            $this->fetchNextRecord();
        }

        /**
         * Implementation of valid() for the Iterator interface.
         */
        public function valid() {
            if (is_null($this->statement)) {
                $this->getAllRecords();
            }
            if ($this->next_record === false) {
                return false;
            }
            return true;
        }

        /**
         * Implementation of rewind() for the Iterator interface.
         */
        public function rewind() {
            $this->statement = null;
            $this->next_record = null;
            $this->cursor = 0;
        }

        /**
         * Implementation of count() for the Countable interface.
         */
        public function count() {
            return $this->getRecordCount();
        }
    }
