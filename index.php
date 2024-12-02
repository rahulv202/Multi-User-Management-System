<?php
define('APP_ROOT', dirname(__FILE__)); //dirname(__DIR__, 2) // Set the root directory as a constant

// Load Composer's Autoloader
require_once APP_ROOT . '\vendor\autoload.php';

// Load Configuration
$config = require APP_ROOT . '\app\config\config.php';
define('CONFIG', $config);
// Autoloader for namespaced classes
spl_autoload_register(function ($class) {
    // $class = str_replace('\\', '/', $class);
    // require_once APP_ROOT . '/' . $class . '.php';
    $classFile = str_replace('\\', DIRECTORY_SEPARATOR, $class . '.php');
    $classPath = APP_ROOT . '/app/' . $classFile;
    if (file_exists($classPath)) {
        require_once $classPath;
    }
});
session_start();

use App\Core\Router;
use App\Middleware\AuthMiddleware;
use App\Middleware\ApiAuthMiddleware;
use App\Middleware\GuestMiddleware;

$router = new Router();
// Define routes
$router->get('/login', 'LoginController@index', [GuestMiddleware::class]);
$router->get('/register', 'RegisterController@index', [GuestMiddleware::class]);
$router->get('/dashboard', 'DashboardController@dashboard', [AuthMiddleware::class]);
$router->get('/logout', 'DashboardController@logout', [AuthMiddleware::class]);
$router->get('/', 'DashboardController@index', [AuthMiddleware::class]);
$router->post('/submit-login', 'LoginController@login', [GuestMiddleware::class]);
$router->post('/submit-register', 'RegisterController@register', [GuestMiddleware::class]);
$router->get('/user-list', 'AdminController@userList');
// API route with ApiAuthMiddleware
$router->get('/api/user', 'ApiController@getUser', [ApiAuthMiddleware::class]);

// Dispatch request
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
