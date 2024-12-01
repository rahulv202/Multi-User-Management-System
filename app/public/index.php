<?php
define('APP_ROOT', dirname(__DIR__, 2)); // Set the root directory as a constant

// Load Composer's Autoloader
require_once APP_ROOT . '\vendor\autoload.php';

// Load Configuration
$config = require APP_ROOT . '\app\config\config.php';

print_r($config);
