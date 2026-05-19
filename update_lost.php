<?php
require_once __DIR__ . '/include/config.php';

mysqli_query($conn, "CREATE TABLE IF NOT EXISTS episodes (
  id int(11) NOT NULL AUTO_INCREMENT,
  post_id int(11) NOT NULL,
  season_number int(11) NOT NULL DEFAULT 1,
  episode_number int(11) NOT NULL DEFAULT 1,
  title varchar(255) NOT NULL,
  description text DEFAULT NULL,
  video_url varchar(500) NOT NULL,
  PRIMARY KEY (id),
  KEY post_id (post_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

$lost = mysqli_query($conn, "SELECT id FROM news WHERE header IN ('Лост', 'Lost') LIMIT 1");
$row = $lost ? mysqli_fetch_assoc($lost) : null;

if ($row) {
    $lostId = (int)$row['id'];
    $stmt = mysqli_prepare($conn, "UPDATE news SET header=?, content=?, image=?, datatime=?, category_id=?, media_type=?, year=?, rating=?, director=?, country=?, duration=?, trailer=?, featured=? WHERE id=?");
} else {
    $stmt = mysqli_prepare($conn, "INSERT INTO news (header, content, image, datatime, category_id, media_type, year, rating, director, country, duration, trailer, featured) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
}

$header = 'Лост';
$content = 'Після авіакатастрофи пасажири рейсу 815 опиняються на загадковому острові. Вони намагаються вижити, знайти спосіб повернутися додому та поступово розкривають таємниці острова, які змінюють їхнє уявлення про реальність.';
$image = 'https://image.tmdb.org/t/p/w500/og6S0aTZU6YUJAbqxeKjCa3kY1E.jpg';
$date = date('Y-m-d');
$category = 2;
$type = 'Серіал';
$year = 2004;
$rating = 8.3;
$director = 'Джей Джей Абрамс, Деймон Лінделоф, Карлтон Кʼюз';
$country = 'США';
$duration = '6 сезонів';
$trailer = 'https://www.youtube.com/watch?v=KTu8iDynwNc';
$featured = 1;

if ($row) {
    mysqli_stmt_bind_param($stmt, 'ssssisidssssii', $header, $content, $image, $date, $category, $type, $year, $rating, $director, $country, $duration, $trailer, $featured, $lostId);
} else {
    mysqli_stmt_bind_param($stmt, 'ssssisidssssi', $header, $content, $image, $date, $category, $type, $year, $rating, $director, $country, $duration, $trailer, $featured);
}
mysqli_stmt_execute($stmt);

if (!$row) {
    $lostId = mysqli_insert_id($conn);
}

mysqli_query($conn, "DELETE FROM episodes WHERE post_id = " . (int)$lostId);
$episodes = [
    [1, 1, 'Пілот, частина 1', 'Початок історії: пасажири рейсу 815 прокидаються після катастрофи на невідомому острові.', 'https://www.youtube.com/embed/KTu8iDynwNc'],
    [1, 2, 'Пілот, частина 2', 'Герої знайомляться ближче й починають розуміти, що острів приховує небезпечні таємниці.', 'https://www.youtube.com/embed/F7_dkEkE50g'],
    [1, 3, 'Табула Раса', 'Перші конфлікти між вцілілими та спроби організувати життя після катастрофи.', 'https://www.youtube.com/embed/x80aRLFK1x4'],
    [1, 4, 'Прогулянка', 'Серія про віру, страхи та особисті таємниці одного з ключових персонажів.', 'https://www.youtube.com/embed/KTu8iDynwNc'],
    [1, 5, 'Білий кролик', 'Пошук відповідей на острові стає дедалі небезпечнішим і дивнішим.', 'https://www.youtube.com/embed/F7_dkEkE50g'],
];

$episodeStmt = mysqli_prepare($conn, "INSERT INTO episodes (post_id, season_number, episode_number, title, description, video_url) VALUES (?, ?, ?, ?, ?, ?)");
foreach ($episodes as $episode) {
    mysqli_stmt_bind_param($episodeStmt, 'iiisss', $lostId, $episode[0], $episode[1], $episode[2], $episode[3], $episode[4]);
    mysqli_stmt_execute($episodeStmt);
}
?>
<!doctype html>
<html lang="uk">
<head>
    <meta charset="utf-8">
    <title>Лост додано</title>
    <style>body{font-family:Arial,sans-serif;background:#111827;color:#f9fafb;padding:40px}.box{max-width:780px;margin:auto;background:#1f2937;padding:28px;border-radius:18px;box-shadow:0 20px 45px rgba(0,0,0,.35)}h1{color:#22c55e}a{color:#93c5fd;font-weight:bold}.btn{display:inline-block;margin-top:14px;background:#2563eb;color:white;text-decoration:none;padding:12px 18px;border-radius:12px}</style>
</head>
<body>
    <div class="box">
        <h1>Серіал «Лост» додано успішно</h1>
        <p>Серіал «Лост» додано як звичайний запис каталогу. На його сторінці доступний вбудований плеєр серій.</p>
        <a class="btn" href="index.php">Перейти на сайт</a>
    </div>
</body>
</html>
