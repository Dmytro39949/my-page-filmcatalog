<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'filmcatalog';

mysqli_report(MYSQLI_REPORT_OFF);
$conn = @mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    echo '<!doctype html><html lang="uk"><head><meta charset="utf-8"><title>Потрібно встановити базу даних</title>';
    echo '<style>body{font-family:Arial,sans-serif;background:#111827;color:#f9fafb;padding:40px} .box{max-width:760px;margin:auto;background:#1f2937;padding:28px;border-radius:18px;box-shadow:0 20px 45px rgba(0,0,0,.35)} a{color:#93c5fd;font-weight:bold} code{background:#374151;padding:3px 6px;border-radius:6px}</style>';
    echo '</head><body><div class="box">';
    echo '<h1>База даних ще не створена</h1>';
    echo '<p>Сайт не може знайти базу <code>filmcatalog</code>.</p>';
    echo '<p>Натисни тут, щоб автоматично створити базу й таблиці: <a href="/filmcatalog.local/install.php">install.php</a></p>';
    echo '<p>Або імпортуй файл <code>database/filmcatalog.sql</code> вручну через phpMyAdmin.</p>';
    echo '</div></body></html>';
    exit();
}

mysqli_set_charset($conn, 'utf8mb4');
?>
