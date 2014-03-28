<?php

    namespace Mvc;

    /**
     * Base class for controllers.
     */
    abstract class Controller {

        protected $request;

        /**
         * Create a new controller and store the incoming request data.
         */
        public function __construct($request) {
            $this->request = $request;
        }
    }
