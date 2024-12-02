<?php

return [
    // Application Settings
    'app_name' => 'Multi-User Management System',
    'base_url' => 'http://localhost:8000/',

    // Database Settings
    'db' => [
        'host' => 'localhost',
        'port' => 3306,
        'name' => 'authdb',
        'user' => 'root',
        'password' => '',
    ],

    // Security Settings
    'jwt_secret' => 'supersecretkey12345',
    'session_lifetime' => 3600, // in seconds

    // Email Settings (optional)
    'email' => [
        'smtp_host' => 'smtp.example.com',
        'smtp_user' => 'user@example.com',
        'smtp_pass' => 'password',
        'smtp_port' => 587,
    ],
];
