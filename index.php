<?php
define('APP_ROOT', dirname(__FILE__)); //dirname(__DIR__, 2) // Set the root directory as a constant

// Load Composer's Autoloader
require_once APP_ROOT . '\vendor\autoload.php';

// Load Configuration
$config = require APP_ROOT . '\app\config\config.php';
define('CONFIG', $config);
// Autoloader for namespaced classes. Custom autoloader function Custom PHP Autoloader (Without Composer)
// spl_autoload_register(function ($class) {
//     // $class = str_replace('\\', '/', $class);
//     // require_once APP_ROOT . '/' . $class . '.php';
//     $classFile = str_replace('\\', DIRECTORY_SEPARATOR, $class . '.php');
//     $classPath = APP_ROOT . '/app/' . $classFile;
//     if (file_exists($classPath)) {
//         require_once $classPath;
//     }
// });
session_start();

use App\Core\Router;
use App\Middleware\AuthMiddleware;
use App\Middleware\ApiAuthMiddleware;
use App\Middleware\AuthAdminRoleMiddleware;
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
$router->get('/user-list', 'AdminController@userList', [AuthAdminRoleMiddleware::class]);
$router->get('/edit-user', 'AdminController@edit_user', [AuthAdminRoleMiddleware::class]);
$router->post("/submit-edit_user", 'AdminController@submit_edit_user', [AuthAdminRoleMiddleware::class]);
$router->get('/delete-user', 'AdminController@delete_user', [AuthAdminRoleMiddleware::class]);
// API route with ApiAuthMiddleware
$router->post('/api/login', 'ApiController@login');
$router->post('/api/register', 'ApiController@register');
$router->get('/api/user-details', 'ApiController@getUserDetails', [new ApiAuthMiddleware(CONFIG)]);
$router->get('/api/user-list', 'AdminController@getUserList', [new ApiAuthMiddleware(CONFIG)]);
$router->post('/api/edit-user', 'AdminController@editUser', [new ApiAuthMiddleware(CONFIG)]);
$router->post('/api/delete-user', 'AdminController@deleteUser', [new ApiAuthMiddleware(CONFIG)]);
$router->post('/api/logout', 'ApiController@logout', [new ApiAuthMiddleware(CONFIG)]);


// Dispatch request
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
