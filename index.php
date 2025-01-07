<?php

require_once __DIR__."/core/Application.php";

$app = new Application();

$app->router->get('/', function() {
    echo "Hello World";
});
$app->router->get("/contact", function() {
    echo "Contact";
});
$app->router->get("/about", function() {
    echo "About";
});

$app->run();