<?php

/**
 * Router script for PHP built-in server
 * Run with: php -S 0.0.0.0:PORT -t /app/public /app/server.php
 * __DIR__ = /app (location of this file, not document root)
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/'
);

// Check if static file exists in public/
// __DIR__ is /app, so public files are at /app/public/...
if ($uri !== '/' && file_exists(__DIR__ . '/public' . $uri)) {
    // Return false tells PHP built-in server to serve the file
    // from document root (-t /app/public) directly
    return false;
}

// Route everything else through Laravel
require_once __DIR__ . '/public/index.php';
