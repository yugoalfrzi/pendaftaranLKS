<?php

/**
 * Router script for PHP built-in server
 * Handles Laravel routing and static file serving
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/'
);

// Document root is /app/public (set via -t flag)
// Static files in public/ are served directly by returning false
if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    return false;
}

// All other requests go through Laravel
require_once __DIR__ . '/index.php';
