<?php
require_once "core/Router.php";

class Application {
    public Router $router;
    public Request $request;

    public function __construct() {
        $this->initializeSession();
        $this->request = new Request();
        $this->router = new Router($this->request);
    }

    private function initializeSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_set_cookie_params([
                'lifetime' => 0,
                'path' => '/',
                'secure' => isset($_SERVER['HTTPS']),
                'httponly' => true,
                'samesite' => 'Lax',
            ]);
            session_start();
        }
    }

    public function run() {
        $this->router->resolve();
    }
}