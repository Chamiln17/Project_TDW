<?php

use Controllers\ProfileController;
require_once "./controllers/ProfileController.php";
require_once "./controllers/HomeController.php";
require_once "./controllers/AuthController.php";
require_once "./controllers/CatalogueController.php";
require_once "./controllers/UserDashboardController.php";
require_once "./controllers/PartnerController.php";
require_once "./controllers/AdvantagesDiscountsController.php";
require_once __DIR__ . "/core/Application.php";

$app = new Application();

$app->router->get('/',[\Controllers\HomeController::class ,'display'] );
$app->router->get('/home',[\Controllers\HomeController::class ,'display'] );
$app->router->get('/login',[\Controllers\AuthController::class ,'display_Login'] );
$app->router->get('/register',[\Controllers\AuthController::class ,'display_Register'] );
$app->router->get('/catalogue',[\Controllers\CatalogueController::class ,'display'] );
$app->router->get('/catalogue/{partnerId}',[\Controllers\PartnerController::class ,'display'] );
$app->router->get('/Dashboard',[\Controllers\UserDashboardController::class ,'display'] );

$app->router->get('dashboard/qrcode/{user_id}', 'UserDashboardController@getQrCode');

$app->router->get('/profile', [ProfileController::class, "display"]);
$app->router->get('/discounts_and_advantages', [\Controllers\AdvantagesDiscountsController::class, 'display']);

$app->router->post('/login',[\Controllers\AuthController::class ,'login'] );
$app->router->post('/register',[\Controllers\AuthController::class ,'register'] );
$app->router->post('/logout',[\Controllers\AuthController::class ,'logout'] );
$app->router->post('/profile/update',[\Controllers\ProfileController::class ,'update_member'] );
$app->router->get("/about", function() {
    echo "About";
});

$app->run();
