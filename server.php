<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 * Router script for PHP built-in server
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/'
);

// Serve static files directly if they exist
if ($uri !== '/' && file_exists(__DIR__ . '/public' . $uri)) {
    return false;
}

// Route everything else through Laravel's index.php
$_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/public/index.php';
$_SERVER['SCRIPT_NAME'] = '/index.php';

require_once __DIR__ . '/public/index.php';
