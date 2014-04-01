<?php

    namespace Mvc;

    use Mvc\Model;

    /**
     * Basic model that supports database backends using PDO.
     */
    class PdoModel extends \Pdo implements Model {

        private $count;
        private $next_record;
        private $position = 0;
        private $sql;
        private $sql_params;
        private $statement;
        private $table;

        /**
         * Connect to the database.
         */
        public function __construct($dsn, $table, $username=null, $password=null) {
            parent::__construct($dsn, $username, $password);
            $this->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->table = $table;
        }

        /**
         * Run a SELECT query with a WHERE ... LIKE clause attached.
         * @param array $filters A list of column=>value pairs.
         */
        public function filter($filters=array()) {
            $sql = sprintf("SELECT * FROM `%s` WHERE 1", $this->table);
            $sql_params = array();
            foreach ($filters as $column => $search) {
                $sql .= sprintf(" AND `%s` LIKE ?", $column);
                $sql_params[] = "%". $search ."%";
            }
            return $this->runSelectQuery($sql, $sql_params);
        }

        /**
         * Run a SELECT query.
         *
         * This runs an SQL SELECT query and prepares the object to iterate over
         * the results. When no query is specified, it defaults to selecting
         * everything.
         * The $sql_params list is a list of values to insert into the
         * sql query while executing it (as a prepared statement).
         * @param string $sql The select statement to use.
         * @param array $sql_params A list of parameters to use.
         */
        protected function runSelectQuery($sql=null, $sql_params=array()) {
            if (is_null($sql) && is_null($this->sql)) {
                $this->sql = sprintf("SELECT * FROM `%s`", $this->table);
                $this->sql_params = array();
            } else {
                $this->sql = $sql;
                $this->sql_params = $sql_params;
            }
            $this->statement = $this->prepare($this->sql);
            $this->statement->execute($this->sql_params);
            $this->count = null;
            return $this;
        }

        /**
         * Retrieve the number of results in the current SELECT query.
         */
        private function runCountQuery() {
            if (is_null($this->sql)) {
                $this->runSelectQuery();
            }
            $regex = '/SELECT.*\sFROM\s/iU';
            $count_sql = preg_replace($regex, "SELECT COUNT(1) FROM ", $this->sql);
            $stmt = $this->prepare($count_sql);
            $stmt->execute($this->sql_params);
            $this->count = (int) $stmt->fetchColumn();
        }

        /**
         * Retrieve the next record from the database backend.
         */
        private function fetchNextRecord() {
            if (is_null($this->statement)) {
                $this->runSelectQuery();
            }
            $this->next_record = $this->statement->fetch(\PDO::FETCH_OBJ);
        }

        /**
         * Implements Countable interface.
         */
        public function count() {
            if (is_null($this->count)) {
                $this->runCountQuery();
            }
            return $this->count;
        }

        /**
         * Implements Iterator interface.
         */
        public function current() {
            if (is_null($this->next_record)) {
                $this->fetchNextRecord();
            }
            return $this->next_record;
        }

        /**
         * Implements Iterator interface.
         */
        public function key() {
            return $this->position;
        }

        /**
         * Implements Iterator interface.
         */
        public function next() {
            $this->position++;
            $this->fetchNextRecord();
        }

        /**
         * Implements Iterator interface.
         */
        public function valid() {
            if (is_null($this->next_record)) {
                $this->fetchNextRecord();
            }
            return is_object($this->next_record);
        }

        /**
         * Implements Iterator interface.
         */
        public function rewind() {
            if ($this->position > 0) {
                $this->next_record = null;
                $this->position = 0;
            }
        }
    }
