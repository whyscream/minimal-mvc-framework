<?php

    use Mvc\Controller;
    use Mvc\View;

    /**
     * Handle some requests that talk about cakes and pies.
     */
    class PiesController extends Controller {

        private $pies;

        /**
         * Create a model based on a sqlite database.
         */
        public function __construct($request) {
            parent::__construct($request);

            $dsn = 'sqlite:/'. __DIR__ . DIRECTORY_SEPARATOR . 'example-app.sqlite';
            $this->pies = new PiesModel($dsn);
        }

        /**
         * Render some data from the model.
         */
        public function indexView() {
            $view = View::factory(__CLASS__, __FUNCTION__);
            // only list pies when their name contains an 'r'
            $view->pies = $this->pies->filter(array('name'=>'R'));
            $view->render();
        }
    }
