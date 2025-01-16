<?php

use Controllers\ProfileController;
require_once "./controllers/ProfileController.php";
require_once "./controllers/HomeController.php";
require_once "./controllers/AuthController.php";
require_once "./controllers/CatalogueController.php";
require_once "./controllers/UserDashboardController.php";
require_once "./controllers/PartnerController.php";
require_once "./controllers/AdvantagesDiscountsController.php";
require_once "./controllers/DonationController.php";
require_once "./controllers/EventController.php";
require_once "./controllers/AdminPartnerController.php";
require_once "./controllers/AdminRemisePartenaireController.php";
require_once __DIR__ . "/core/Application.php";

$app = new Application();
$app->router->get("/404_Error", function() {
    echo "404 Error";
});
$app->router->get('/',[\Controllers\HomeController::class ,'display'] );
$app->router->get('/home',[\Controllers\HomeController::class ,'display'] );
$app->router->get('/login',[\Controllers\AuthController::class ,'display_Login'] );
$app->router->get("/admin/login",[\Controllers\AuthController::class,"display_login_admin"]);

$app->router->get('/register',[\Controllers\AuthController::class ,'display_Register'] );
$app->router->get('/catalogue',[\Controllers\CatalogueController::class ,'display'] );
$app->router->get('/catalogue/{partnerId}',[\Controllers\PartnerController::class ,'display'] );
$app->router->get('/Dashboard',[\Controllers\UserDashboardController::class ,'display'] );
$app->router->get('dashboard/qrcode/{user_id}', 'UserDashboardController@getQrCode');
$app->router->get('/profile', [ProfileController::class, "display"]);
$app->router->get('/discounts_and_advantages', [\Controllers\AdvantagesDiscountsController::class, 'display']);
$app->router->get('/donation', [\Controllers\DonationController::class, 'displayDonationForm']);
$app->router->get("/donation/history",[\Controllers\DonationController::class, 'displayDonationHistory']);
$app->router->get("/events/{event_id}",[\Controllers\EventController::class, 'displayEventDetails']);
$app->router->get("/events",[\Controllers\EventController::class, 'displayEvents']);

$app->router->get("/admin/partners", [\Controllers\AdminPartnerController::class, "displayPartners"]);
$app->router->get("/admin/partners/new", [\Controllers\AdminPartnerController::class, "add"]);
$app->router->get("/admin/partners/edit/{id}", [\Controllers\AdminPartnerController::class, "edit"]);

// Routes for Remises et Avantages
$app->router->get("/admin/partners/remises/{id}", [\Controllers\AdminRemisePartenaireController::class, "displayRemises"]);
$app->router->post("/admin/partners/remises/{id}/add-discount", [\Controllers\AdminRemisePartenaireController::class, "addDiscount"]);
$app->router->post("/admin/partners/remises/{id}/add-advantage", [\Controllers\AdminRemisePartenaireController::class, "addAdvantage"]);
$app->router->get("/admin/partners/remises/{id}/edit-discount/{discountId}", [\Controllers\AdminRemisePartenaireController::class, "editDiscount"]);
$app->router->post("/admin/partners/remises/{id}/update-discount/{discountId}", [\Controllers\AdminRemisePartenaireController::class, "updateDiscount"]);
$app->router->get("/admin/partners/remises/{id}/edit-advantage/{advantageId}", [\Controllers\AdminRemisePartenaireController::class, "editAdvantage"]);
$app->router->post("/admin/partners/remises/{id}/update-advantage/{advantageId}", [\Controllers\AdminRemisePartenaireController::class, "updateAdvantage"]);
$app->router->post("/admin/partners/remises/{id}/delete-discount/{discountId}", [\Controllers\AdminRemisePartenaireController::class, "deleteDiscount"]);
$app->router->post("/admin/partners/remises/{id}/delete-advantage/{advantageId}", [\Controllers\AdminRemisePartenaireController::class, "deleteAdvantage"]);
//routes for admin members

$app->router->get('/admin/members', [\Controllers\MemberController::class, 'displayMembers']);
$app->router->get('/admin/members/{id}', [\Controllers\MemberController::class, 'displayMemberDetails']);
$app->router->post('/admin/members/approve/{id}', [\Controllers\MemberController::class, 'updateMemberStatus']);
$app->router->post('/admin/members/reject/{id}', [\Controllers\MemberController::class, 'updateMemberStatus']);
$app->router->post('/admin/members/delete/{id}', [\Controllers\MemberController::class, 'deleteMember']);

$app->router->post("/admin/partners/create", [\Controllers\AdminPartnerController::class, "create"]);
$app->router->post("/admin/partners/update/{id}", [\Controllers\AdminPartnerController::class, "update"]);
$app->router->post("/admin/partners/delete/{id}", [\Controllers\AdminPartnerController::class, "delete"]);


$app->router->post('/login',[\Controllers\AuthController::class ,'login'] );
$app->router->post("/admin/login",[\Controllers\AuthController::class,"loginAdmin"]);
$app->router->post('/register',[\Controllers\AuthController::class ,'register'] );
$app->router->post('/logout',[\Controllers\AuthController::class ,'logout'] );
$app->router->post('/profile/update',[\Controllers\ProfileController::class ,'update_member'] );
$app->router->post('/donation/submit', [\Controllers\DonationController::class, 'handleDonation']);
$app->router->post('/events/{eventId}/register', [\Controllers\EventController::class, 'handleVolunteerRegistration']);
$app->router->post("/catalogue/{partner_id}/favorite",[\Controllers\PartnerController::class ,'handleFavorite']);


$app->run();
