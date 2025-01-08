<?php
require_once "./controllers/HomeController.php";
require_once "Request.php";

class Router {
    protected array $routes = [];
    public Request $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function get($path, $callback) {
        $this->routes['get'][$path] = $callback;
    }

    public function resolve() {
        $path = $this->request->getPath();
        $method = strtolower($this->request->getMethod()); // Ensure method is lowercase
        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
            // Route not found
            http_response_code(404);
            echo "404 Not Found";
            return;
        }

        // If callback is an array, ensure the class instance is created
        if (is_array($callback)) {
            $callback[0] = new $callback[0]();
        }

        // Call the callback
        echo call_user_func($callback);
    }

}
