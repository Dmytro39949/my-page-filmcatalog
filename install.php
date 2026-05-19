<?php
$host = 'localhost';
$user = 'root';
$password = '';
$sqlFile = __DIR__ . '/database/filmcatalog.sql';

mysqli_report(MYSQLI_REPORT_OFF);
$conn = @mysqli_connect($host, $user, $password);

function page($title, $message, $isOk = true) {
    $color = $isOk ? '#22c55e' : '#ef4444';
    echo '<!doctype html><html lang="uk"><head><meta charset="utf-8"><title>' . htmlspecialchars($title) . '</title>';
    echo '<style>body{font-family:Arial,sans-serif;background:#111827;color:#f9fafb;padding:40px}.box{max-width:780px;margin:auto;background:#1f2937;padding:28px;border-radius:18px;box-shadow:0 20px 45px rgba(0,0,0,.35)}h1{color:' . $color . '}a{color:#93c5fd;font-weight:bold}code{background:#374151;padding:3px 6px;border-radius:6px}.btn{display:inline-block;margin-top:14px;background:#2563eb;color:white;text-decoration:none;padding:12px 18px;border-radius:12px}</style>';
    echo '</head><body><div class="box"><h1>' . htmlspecialchars($title) . '</h1><p>' . $message . '</p><a class="btn" href="index.php">Перейти на сайт</a></div></body></html>';
}

if (!$conn) {
    page('Помилка підключення до MySQL', 'Перевір, чи запущені <b>Apache</b> і <b>MySQL</b> у XAMPP. Деталі: <code>' . htmlspecialchars(mysqli_connect_error()) . '</code>', false);
    exit();
}

if (!file_exists($sqlFile)) {
    page('SQL-файл не знайдено', 'Не знайдено файл <code>database/filmcatalog.sql</code>. Перевір, чи повністю розпакований архів.', false);
    exit();
}

$sql = file_get_contents($sqlFile);
if (!$sql) {
    page('SQL-файл порожній', 'Файл <code>database/filmcatalog.sql</code> не вдалося прочитати.', false);
    exit();
}

if (mysqli_multi_query($conn, $sql)) {
    do {
        if ($result = mysqli_store_result($conn)) {
            mysqli_free_result($result);
        }
    } while (mysqli_more_results($conn) && mysqli_next_result($conn));
}

if (mysqli_errno($conn)) {
    page('Помилка імпорту бази', 'MySQL повернув помилку: <code>' . htmlspecialchars(mysqli_error($conn)) . '</code>', false);
    exit();
}

page('Базу даних створено успішно', 'Створено базу <code>filmcatalog</code>, таблиці, меню, категорії, записи фільмів/серіалів і серії для плеєра серіалу «Лост». Тепер можна відкривати сайт.');
?>
