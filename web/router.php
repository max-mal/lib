<?php

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

if (file_exists(__DIR__ . '/' . $uri)) {
    return false;
}


if (strpos($uri, 'backend') !== false) {
    require_once __DIR__ . '/backend/index.php';
} elseif (strpos($uri, 'manage') !== false) {
    require_once __DIR__ . '/manage/index.php';
} elseif (strpos($uri, 'api') !== false) {
    require_once __DIR__ . '/api/index.php';
} else {
    require_once __DIR__ . '/index.php';
}
