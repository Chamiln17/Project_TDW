<?php
class Request {
    public function getPath() {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $basePath = '/Project_TDW'; // Adjust based on your project root in XAMPP

        // Remove the base path from the request URI
        if (strpos($path, $basePath) === 0) {
            $path = substr($path, strlen($basePath));
        }

        // Handle query strings
        $position = strpos($path, '?');
        if ($position !== false) {
            $path = substr($path, 0, $position);
        }

        return $path ?: '/';
    }

    public function getMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getBody() {
        $body = [];

        if ($this->getMethod() === 'GET') {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($this->getMethod() === 'POST') {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $body;
    }
}
