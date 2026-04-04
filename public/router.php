<?php

/**
 * Router script for PHP built-in server with pretty URLs.
 *
 * Usage: php -S localhost:8080 -t public public/router.php
 */

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Serve existing static files directly (CSS, JS, images, etc.)
if ($path !== '/' && is_file(__DIR__ . $path)) {
    return false;
}

// Route everything else through index-test.php for test environment
require __DIR__ . '/index-test.php';
