<?php

// Ensure /tmp has necessary storage directories for views and cache
$storageDirs = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
];

foreach ($storageDirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Copy pre-seeded SQLite database to writable /tmp directory
$tmpDb = '/tmp/database.sqlite';
$sourceDb = __DIR__ . '/../database/database.sqlite';
if (!file_exists($tmpDb)) {
    if (file_exists($sourceDb)) {
        copy($sourceDb, $tmpDb);
    } else {
        touch($tmpDb);
    }
}

// Require public/index.php to run Laravel
require __DIR__ . '/../public/index.php';
