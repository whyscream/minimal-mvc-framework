<?php

    use Mvc\Controller;
    use Mvc\View;

    /**
     * The Default Controller handles requests to the document root (i.e.
     * the default page at the top of the application.
     */
    class DefaultController extends Controller {

        /**
         * An example of the most simple way to use a view.
         */
        function indexView() {
            $view = View::factory(__CLASS__, __FUNCTION__);
            $view->controller = __CLASS__;
            $view->view = __FUNCTION__;
            $view->render();
        }
    }
