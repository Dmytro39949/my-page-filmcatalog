<?php
require_once __DIR__ . '/auth.php';

$uploadDir = __DIR__ . '/../img/uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$image = trim($_POST['image_url'] ?? '');
if ($image === '') {
    $image = $_POST['current_image'] ?? 'img/no-image.svg';
}
if (isset($_FILES['image']) && $_FILES['image']['tmp_name'] !== '') {
    $safeName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $safeName);
    $image = 'img/uploads/' . $safeName;
}

$featured = isset($_POST['featured']) ? 1 : 0;

$sql = "UPDATE news SET
            header = ?,
            content = ?,
            image = ?,
            datatime = ?,
            category_id = ?,
            media_type = ?,
            year = ?,
            rating = ?,
            director = ?,
            country = ?,
            duration = ?,
            trailer = ?,
            featured = ?
        WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param(
    $stmt,
    'ssssisidssssii',
    $_POST['header'],
    $_POST['content'],
    $image,
    $_POST['datetime'],
    $_POST['category_id'],
    $_POST['media_type'],
    $_POST['year'],
    $_POST['rating'],
    $_POST['director'],
    $_POST['country'],
    $_POST['duration'],
    $_POST['trailer'],
    $featured,
    $_POST['id']
);
mysqli_stmt_execute($stmt);

header('Location: index.php');
exit();
?>
