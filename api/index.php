<?php

// Mengarahkan storage agar bisa ditulisi di direktori /tmp Vercel
$_ENV['APP_STORAGE'] = $_ENV['APP_STORAGE'] ?? '/tmp/storage';

// Buat direktori temporary jika belum ada
if (!is_dir('/tmp/storage')) {
    mkdir('/tmp/storage', 0777, true);
    mkdir('/tmp/storage/framework', 0777, true);
    mkdir('/tmp/storage/framework/views', 0777, true);
    mkdir('/tmp/storage/framework/cache', 0777, true);
    mkdir('/tmp/storage/framework/sessions', 0777, true);
    mkdir('/tmp/storage/logs', 0777, true);
}

// Jalankan aplikasi Laravel dari public folder
require __DIR__ . '/../public/index.php';
<?php

require __DIR__ . '/../public/index.php';
