<?php
require_once "Request.php";
class Router {
    protected array $routes = [];
    public Request $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function get($path, $callback) {
        // Convert route parameters to regex pattern
        $pattern = $this->createRoutePattern($path);
        $this->routes['get'][$pattern] = $callback;
    }

    public function post($path, $callback) {
        $pattern = $this->createRoutePattern($path);
        $this->routes['post'][$pattern] = $callback;
    }

    private function createRoutePattern($path) {
        // Convert {parameter} to named capture groups
        return preg_replace('/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/', '(?P<$1>[^/]+)', $path);
    }

    private function matchRoute($path, $routes) {
        foreach ($routes as $pattern => $callback) {
            // Add delimiters and escape forward slashes
            $fullPattern = "#^" . str_replace('/', '\/', $pattern) . "$#";

            if (preg_match($fullPattern, $path, $matches)) {
                // Filter out numeric keys from matches
                $params = array_filter($matches, function($key) {
                    return !is_numeric($key);
                }, ARRAY_FILTER_USE_KEY);

                return ['callback' => $callback, 'params' => $params];
            }
        }
        return false;
    }

    public function resolve() {
        $path = $this->request->getPath();
        $method = strtolower($this->request->getMethod());

        // Get routes for current method
        $routes = $this->routes[$method] ?? [];

        // Try to match the route
        $match = $this->matchRoute($path, $routes);

        if ($match === false) {
            http_response_code(404);
            echo "404 Not Found";
            return;
        }

        $callback = $match['callback'];
        $params = $match['params'];

        // If callback is an array [class, method]
        if (is_array($callback)) {
            $controller = new $callback[0]();
            return call_user_func_array([$controller, $callback[1]], $params);
        }

        // If callback is a closure/function
        return call_user_func_array($callback, $params);
    }
}
