<?php

    use Mvc\Controller;
    use Mvc\View;
    use Mvc\JsonModel;
    use Mvc\Application;

    /**
     * The PersonsController is used to handle various requests
     * about a set of persons. The person data is provided by a JsonModel.
     */
    class PersonsController extends Controller {

        private $persons;

        /**
         * Instantiate controller, retrieve model data.
         */
        function __construct() {
            // load Persons model from json data
            $this->persons = new JsonModel(__DIR__ . DIRECTORY_SEPARATOR .'persons.json');
        }

        /**
         * Handle requests to display a list of persons
         */
        function indexView() {
            $view = View::factory(__CLASS__, __FUNCTION__);
            $view->person_count = count($this->persons);
            $view->persons = $this->persons;
            $view->render();
        }

        /**
         * Handle requests to display details about a single person
         * @param array $request The request data.
         */
        function detailView($request) {
            $person_name = array_shift($request);
            if (is_null($person_name)) {
                // no person name specified in request
                Application::handleError(404);
                exit;
            }

            // check if person exists
            $found = false;
            foreach ($this->persons as $person) {
                if (strcasecmp($person->name, $person_name) == 0) {
                    $found = true;
                    break;
                }
            }

            if(!$found) {
                // specified person name does not exist in model
                Application::handleError(404);
                exit;
            }

            $view = View::factory(__CLASS__, __FUNCTION__);
            $view->person = $person;
            $view->render();
        }
    }
