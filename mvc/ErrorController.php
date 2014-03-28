<?php

    namespace Mvc;

    use Mvc\Controller;

    /**
     * Basic controller that formats application errors into user friendly error pages.
     */
    class ErrorController extends Controller {

        // contents of error messages (short, long), loosely based on apache output.
        private $error_details = array(
            404 => array(
                "Not Found",
                "The requested URL %s was not found on this server.",
            ),
            500 => array(
                "Internal Server Error",
                "The server encountered an unexpected condition which prevented it from fulfilling the request.",
            ),
        );

        private $exception;

        /**
         * Display user friendly error messages.
         */
        public function indexView() {
            // create custom path to template to avoid complex directory structures
            $view_file = __DIR__ . DIRECTORY_SEPARATOR .'ErrorView.phtml';
            $view = new View($view_file);

            $code = intval($this->request[0]);
            list($code, $short, $long) = $this->getErrorDetails($code);

            $view->error_code = $code;
            $view->error_short = $short;
            $view->error_long = $long;
            $view->hostname = $_SERVER['SERVER_NAME'];
            $view->mvc_name = 'Mvc';

            header(sprintf("HTTP/1.0 %d %s", $code, $short));
            $view->render();
        }

        /**
         * Return short and long descriptions for HTTP error codes.
         * @param int $code The HTTP error code to return data for.
         * @returns array A list containing error code, short and long error description.
         */
        private function getErrorDetails($code) {
            if (!isset($this->error_details[$code])) {
                $code = 404;
            }
            list($short, $long) = $this->error_details[$code];

            // append exception output
            if (!is_null($this->exception)) {
                $long = sprintf("%s<br/>Error message is: %s", $long, $this->exception->getMessage());
            }

            // some customizations when needed
            switch ($code) {
                case 404:
                    $long = sprintf($long, $_SERVER['REQUEST_URI']);
                    break;
            }

            return array($code, $short, $long);
        }

        /**
         * Set the exception to handle, which is used to generate a custom error message.
         * @param Exception $err The exception.
         */
        public function setException($err) {
            $this->exception = $err;
        }
    }
