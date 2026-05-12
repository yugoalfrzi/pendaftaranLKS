<?php

/**
 * Router script for PHP built-in server
 * Place this in project root, run with: php -S 0.0.0.0:PORT -t public server.php
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/'
);

// public/ is the document root (-t public)
// Static files are served directly by returning false
if ($uri !== '/' && file_exists(__DIR__ . '/public' . $uri)) {
    return false;
}

// All other requests go through Laravel's front controller
require_once __DIR__ . '/public/index.php';
