<?php

/**
 * Application core class
 * Load Controller class based on URL elements
 */
class Application
{
    private $activeController = null;
    private $activeAction = null;
    private $activeParams = array();

    /**
     * Load Controller class based on URL elements or a fallback
     */
    public function __construct()
    {
        $this->splitURL();

        // If no active controller -> load and create home controller
        if (!$this->activeController) {
            require APPLICATION . 'controller/' . ucfirst(DEFAULT_CONTROLLER) . 'Controller.php';
            $page = new Home();
            $page->index();

        // If active controller file exists -> load and create active controller
        } elseif (file_exists(APPLICATION . 'controller/' . ucfirst($this->activeController) . 'Controller.php')) {
            require APPLICATION . 'controller/' . ucfirst($this->activeController) . 'Controller.php';
            $this->activeController = new $this->activeController;

            // If there is no active action -> call index action
            if (strlen($this->activeAction) == 0) {
                $this->activeController->index();

            // If active action exists in controller
            } elseif (method_exists($this->activeController, $this->activeAction)) {
                // If no active params
                if (!empty($this->activeParams)) {
                    // Call action with params
                    call_user_func_array(array($this->activeController, $this->activeAction), $this->activeParams);
                } else {
                    // Call action without params
                    $activeAction = $this->activeAction;
                    $this->activeController->$activeAction();
                }
            } else {
                // No action found -> redirect to error 404 page
                header('location: ' . URL . 'problem/error404');exit;
            }
        } else {
            // No controller found -> redirect to error 404 page
            header('location: ' . URL . 'problem/error404');exit;
        }
    }

    /**
     * Split URL and return active controller and active action
     * Set optional params
     */
    private function splitURL()
    {
        if (isset($_GET['url'])) {

            // Split URL
            $url = trim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            // Set active controller & action
            $this->activeController = (isset($url[0]) ? $url[0] : null);
            $this->activeAction = (isset($url[1]) ? $url[1] : null);

            // Remove active controller & action from URL
            unset($url[0], $url[1]);

            // Set URL params
            $this->activeParams = array_values($url);
        }
    }
}
