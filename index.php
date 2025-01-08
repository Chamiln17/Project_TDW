<?php

require_once __DIR__ . "/core/Application.php";

$app = new Application();

$app->router->get('/',[\Controllers\HomeController::class ,'display'] );
$app->router->get('/home',[\Controllers\HomeController::class ,'display'] );
$app->router->get('/login',[\Controllers\AuthController::class ,'display_Login'] );
$app->router->get('/register',[\Controllers\AuthController::class ,'display_Register'] );

$app->router->get("/about", function() {
    echo "About";
});

$app->run();
