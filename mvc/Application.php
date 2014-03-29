<?php

    namespace Mvc;

    use Mvc\ErrorController as MvcErrorController;

    /**
     * Handles requests and sets up a correct environment.
     *
     * The Application class is the starting point of the MVC framework.
     * It manages the incoming request, decides which Controller and View
     * objects are needed, and then runs them. There is also basic error
     * handling available to suppress exceptions for end users.
     */
    class Application {

        public static $path;
        private $default_controller;
        private $default_view;

        /**
         * Create a new application environment.
         *
         * @param string $application_path Path to the directory that contains the application to run.
         * @param string $default_controller Name of the Controller to use when the request doesn't specify it.
         * @param string $default_view Name of the View to use when the request doesn't specify it.
         */
        public function __construct($application_path, $default_controller='default', $default_view='index') {
            if (!is_dir($application_path) || !is_readable($application_path)) {
                throw new \InvalidArgumentException(sprintf(
                    "Application path '%s' is no valid directory",
                    $application_path
                ));
            }
            self::$path = $application_path;

            $this->default_controller = $default_controller;
            $this->default_view = $default_view;

            // set up autoloading for controllers
            spl_autoload_register(function($class_name) {
                $class_path = Application::$path . DIRECTORY_SEPARATOR
                            . $class_name .'.php';
                if (!is_readable($class_path)) {
                    return;
                }
                require $class_path;
            });
        }


        /**
         * Handle an incoming request, and run the associated controller.
         *
         * If no $request argument is set (the default), a request is generated
         * based on the webserver REQUEST_URI.
         *
         * @param array $request A request, formatted as a list containing
         *                       controller name, view name, and additional data.
         */
        public function run($request=null) {
            if (is_null($request)) {
                $request = $_SERVER['REQUEST_URI'];
            }

            if (!is_array($request)) {
                $regex = '/\//';
                $request = preg_split($regex, $request, -1, PREG_SPLIT_NO_EMPTY);
            }

            $controller_name = array_shift($request);
            if (is_null($controller_name)) {
                $controller_name = $this->default_controller;
            }

            $view_name = array_shift($request);
            if (is_null($view_name)) {
                $view_name = $this->default_view;
            }

            $controller_name = ucfirst(strtolower($controller_name)) .'Controller';
            if (!class_exists($controller_name)) {
                // no such controller
                self::handleError(404);
                exit;
            }

            $view_name = strtolower($view_name) .'View';
            try {
                $controller = new $controller_name($request);
                $controller->$view_name($request);
            } catch (\Exception $err) {
                // an exception inside a controller occurred
                self::handleException($err);
                exit;
            }
        }

        /**
         * Use the builtin ErrorController to display errors.
         *
         * @param int $error_code The HTTP error code to display.
         */
        public static function handleError($error_code) {
            $controller = new MvcErrorController(array($error_code));
            $controller->indexView();
        }

        /**
         * Use the builtin ErrorController to display exceptions.
         *
         * @param \Exception $err The Exception to display.
         */
        public static function handleException($err) {
            $controller = new MvcErrorController(array(500));
            $controller->setException($err);
            $controller->indexView();
        }
    }
