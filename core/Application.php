<?php
require_once "core/Router.php";

class Application {
    public Router $router;
    public Request $request;

    public function __construct() {
        $this->initializeSession(); // Initialize session
        $this->request = new Request();
        $this->router = new Router($this->request);
    }

    private function initializeSession() {
        // Only configure and start the session if it's not already active
        if (session_status() === PHP_SESSION_NONE) {
            // Configure session cookie parameters
            session_set_cookie_params([
                'lifetime' => 0,            // Session expires on browser close
                'path' => '/',
                'secure' => isset($_SERVER['HTTPS']), // Use secure cookies if HTTPS
                'httponly' => true,         // Prevent JavaScript access
                'samesite' => 'Lax',        // Adjust based on your needs
            ]);

            // Start the session
            session_start();
        }
    }

    public function run() {
        $this->router->resolve();
    }
}
