<?php
define('APP_ROOT', dirname(__FILE__)); //dirname(__DIR__, 2) // Set the root directory as a constant

// Load Composer's Autoloader
require_once APP_ROOT . '\vendor\autoload.php';

// Load Configuration
$config = require APP_ROOT . '\app\config\config.php';

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

$router = new Router();
// Define routes
$router->get('/login', 'loginController@index', [AuthMiddleware::class]);
$router->get('/register', 'registerController@index', [AuthMiddleware::class]);
$router->get('/dashboard', 'dashboardController@dashboard', [AuthMiddleware::class]);
$router->get('/logout', 'logoutController@logout', [AuthMiddleware::class]);
$router->get('/', 'homeController@index', [AuthMiddleware::class]);
$router->post('/submit-login', 'loginController@login', [AuthMiddleware::class]);
$router->post('/submit-register', 'registerController@register', [AuthMiddleware::class]);
// API route with ApiAuthMiddleware
$router->get('/api/user', 'ApiController@getUser', [ApiAuthMiddleware::class]);

// Dispatch request
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
