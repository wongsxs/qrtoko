<?php

if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
}

// Ensure /tmp has necessary storage directories for views and cache
$storageDirs = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
];

foreach ($storageDirs as $dir) {
    if (! is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

$_ENV['LARAVEL_STORAGE_PATH'] = '/tmp/storage';
$_SERVER['LARAVEL_STORAGE_PATH'] = '/tmp/storage';

// Copy pre-seeded SQLite database to writable /tmp directory if using SQLite
if (getenv('DB_CONNECTION') === 'sqlite') {
    $tmpDb = '/tmp/database.sqlite';
    $sourceDb = __DIR__.'/../database/database.sqlite';
    if (! file_exists($tmpDb)) {
        if (file_exists($sourceDb)) {
            copy($sourceDb, $tmpDb);
        } else {
            touch($tmpDb);
        }
    }
}

// Require public/index.php to run Laravel
require __DIR__.'/../public/index.php';
