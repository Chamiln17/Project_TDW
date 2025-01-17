# Project_TDW
This project was developed using PHP,Tailwind,JS and HTML5 and run under XAMPP 
# Project MVC Architecture

This project follows the Model-View-Controller (MVC) architectural pattern, which separates the application into three main components: Models, Views, and Controllers. This separation helps in organizing the code, making it more maintainable and scalable.

## Folder Structure
````plaintext
project/  
│  
├── .gitignore  
├── .htaccess  
├── index.php  
├── README.md  
│  
├── .idea/  
│   ├── .gitignore  
│   ├── modules.xml  
│   └── ...  
│  
├── assets/  
│   ├── images/  
│   │   ├── 5439086-uhd_3840_2160_25fps.mp4  
│   │   └── heart-hands.png  
│   └── ...  
│  
├── Controllers/  
│   ├── AuthController.php  
│   └── CatalogueController.php  
│  
├── core/  
│   ├── Application.php  
│   └── Database.php  
│  
├── Models/  
│   ├── HomeModel.php  
│   └── UserModel.php  
│  
├── Temp/  
│   └── .gitignore  
│  
├── Views/  
│   ├── admin/  
│   │   ├── donations.php  
│   │   └── members.php  
│   ├── includes/  
│   │   ├── footer.php  
│   │   └── header.php  
│   ├── members/  
│   └── public/  
│       ├── BenefitsView.php  
│       └── CatalogueView.php  
````

## Components

### Models

Models are responsible for handling the data and business logic of the application. They interact with the database and perform operations such as querying, inserting, updating, and deleting data.

- `Models/UserModel.php`: Manages user-related data and operations, such as registration and login.
- `Models/HomeModel.php`: Manages data related to the home page.

### Views

Views are responsible for displaying the data to the user. They contain the HTML and PHP code to render the user interface.

- `Views/public/`: Contains the public-facing views such as `HomeView.php`, `LoginView.php`, `RegisterView.php`, etc.
- `Views/admin/`: Contains the admin views such as `donations.php`, `members.php`, `notification.php`, etc.
- `Views/includes/`: Contains reusable components like `header.php` and `footer.php`.

### Controllers

Controllers act as intermediaries between Models and Views. They handle user input, process it, and update the Models and Views accordingly.

- `Controllers/AuthController.php`: Manages authentication-related actions such as login and registration.
- `Controllers/CatalogueController.php`: Manages actions related to the catalogue.
- `Controllers/HomeController.php`: Manages actions related to the home page.

### Core

The core directory contains the essential classes that support the MVC framework.

- `core/Application.php`: Initializes the application, sets up the router, and starts the session.
- `core/Database.php`: Manages the database connection and queries.
- `core/Request.php`: Handles HTTP requests and extracts the request path and method.
- `core/Router.php`: Manages the routing of HTTP requests to the appropriate controllers and actions.

### Entry Point

- `index.php`: The entry point of the application. It initializes the `Application` class, sets up the routes, and runs the application.

## Routing

The routing is managed by the `Router` class in `core/Router.php`. Routes are defined in `index.php` and map URLs to specific controller actions.

Example routes:
```php
$app->router->get('/', [\Controllers\HomeController::class, 'display']);
$app->router->get('/home', [\Controllers\HomeController::class, 'display']);
$app->router->get('/login', [\Controllers\AuthController::class, 'display_Login']);
$app->router->get('/register', [\Controllers\AuthController::class, 'display_Register']);
$app->router->get('/catalogue', [\Controllers\CatalogueController::class, 'display']);
```

## Database
The Database class in ``core/Database.php`` manages the connection to the MySQL database using PDO. It provides methods to ``connect``, ``disconnect``, ``execute queries``, and ``fetch results``.  
## Session Management
The ``Application`` class initializes the session with secure cookie parameters to ensure the session is properly managed and secure.  
