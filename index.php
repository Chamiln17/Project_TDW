<?php

require_once __DIR__ . "/core/Application.php";

$app = new Application();

$app->router->get('/',[\Controllers\HomeController::class ,'display'] );

$app->router->get("/about", function() {
    echo "About";
});

$app->run();
