<?php
require_once "./controllers/HomeController.php";
require_once "./controllers/AuthController.php";
require_once "./controllers/CatalogueController.php";

require_once __DIR__ . "/core/Application.php";

$app = new Application();

$app->router->get('/',[\Controllers\HomeController::class ,'display'] );
$app->router->get('/home',[\Controllers\HomeController::class ,'display'] );
$app->router->get('/login',[\Controllers\AuthController::class ,'display_Login'] );
$app->router->get('/register',[\Controllers\AuthController::class ,'display_Register'] );
$app->router->get('/catalogue',[\Controllers\CatalogueController::class ,'display'] );
$app->router->post('/login',[\Controllers\AuthController::class ,'login'] );
$app->router->post('/register',[\Controllers\AuthController::class ,'register'] );
$app->router->post('/logout',[\Controllers\AuthController::class ,'logout'] );
$app->router->get("/about", function() {
    echo "About";
});

$app->run();
