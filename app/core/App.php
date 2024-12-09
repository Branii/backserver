
<?php
class App extends Controller
{
    protected $AdminController = 'adminController';
    protected $action = 'index';
    protected $params = [];

    public function __construct()
    {
        $this->prepareURL();
    }

    public function prepareURL()
    {
        $request = trim($_SERVER['REQUEST_URI'], '/');

        if (!empty($request)) {
            $url = explode("/", $request);
            // print_r($url);
            // exit;

            $this->AdminController = isset($url[2]) ? $url[2] . "Controller" : "adminController";
            $this->action = isset($url[3]) ? $url[3] : "index";
            array_splice($url, 0, 4);
            $this->params = !empty($url) ? array_values($url) : [];

            if (file_exists(CONTROLLER . $this->AdminController . ".php")) {

                $this->AdminController = new $this->AdminController;

                if (method_exists($this->AdminController, $this->action)) {

                    call_user_func_array([$this->AdminController, $this->action], $this->params);
                } else {
                   // (new adminController)->notfound();
                    //echo "Method '{$this->action}' not found in '{$this->AdminController}'";
                }

            } else {
               // (new adminController)->notfound();
                //echo "Controller '{$this->AdminController}' not found";
            }
        }
    }
}
