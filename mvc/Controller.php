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

        /**
         * Fallback method for rendering views directly from a template.
         *
         * This method allows for returning output directly from a view
         * template, without the need to implement the
         * ``<viewname>View()`` method in the Controller.
         */
        public function __call($view_name, $arguments) {
            $class_name = get_class($this);
            $view = View::factory($class_name, $view_name);
            try {
                $view->render();
            } catch (\InvalidArgumentException $err) {
                // view template file does not exist
                Application::handleError(404);
            }
        }
    }
