<?php
require_once "Request.php";
class Router {
    protected $routes = [];
    public Request $request;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param array $routes
     */

    public function get($path, $callback) {
        $this->routes['get']["/Project_TDW".$path] = $callback;

    }

    public function resolve()
    {
        $path= $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false ;
        if ($callback===false){
            echo "Not found";
            exit();
        }
        echo call_user_func($callback);
    }
}