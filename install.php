<?php
require_once __DIR__ . '/include/config.php';

if (!headers_sent()) {
    header('Location: /filmcatalog.local/');
    exit();
}

echo 'Перенаправлення...';
