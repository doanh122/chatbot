<?php

require_once __DIR__ . '/vendor/autoload.php';

// Nạp tệp .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Đọc giá trị từ biến môi trường
define("OPENAI_API_KEY", getenv('OPEN_API_KEY'));
define("DB_HOST", getenv('DB_HOST'));
define("DB_NAME", getenv('DB_NAME'));
define("DB_USER", getenv('DB_USER'));
define("DB_PASS", getenv('DB_PASS'));

// Kiểm tra giá trị đã lấy được
echo OPENAI_API_KEY;  // In ra API Key đã lấy từ .env
echo DB_HOST;         // In ra DB Host
