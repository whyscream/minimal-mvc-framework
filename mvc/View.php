<?php

    namespace Mvc;

    use Mvc\Application;

    /**
     * Class that handles template files.
     */
    class View {

        protected $file;

        /**
         * Create a new view based on a template.
         *
         * @param string $view_file The .phtml template file.
         */
        public function __construct($view_file) {
            $this->file = $view_file;
        }

        /**
         * Generate a new view object based on controller and view name.
         *
         * The parameters are used to generate the path where the template file should reside.
         *
         * @param string $controller_name The controller to use.
         * @param string $view_name The view to use.
         */
        public static function factory($controller_name, $view_name) {
            // remove Controller suffix from controller
            $controller_name = preg_replace('/Controller$/', '', $controller_name);

            // remove View suffix from view
            $view_name = preg_replace('/View$/', '', $view_name);

            // contruct path to template file
            $view_file = Application::$path . DIRECTORY_SEPARATOR
                       . $controller_name . DIRECTORY_SEPARATOR
                       . $view_name .'.phtml';

            $view_class = __CLASS__;
            return new $view_class($view_file);
        }

        /**
         * Output a view to the browser.
         *
         * Reads the template file and makes all set variables available to the template.
         */
        public function render() {
            if (!is_readable($this->file)) {
                throw new \InvalidArgumentException(sprintf(
                    "View template file '%s' is unavailable",
                    $this->file
                ));
            }

            extract(get_object_vars($this));
            require $this->file;
        }
    }
