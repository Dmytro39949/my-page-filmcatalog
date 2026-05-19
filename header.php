<?php
require_once __DIR__ . '/include/functions.php';
$menus = get_menu();
$categories = get_categories();
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MovieSpace - Каталог фільмів та серіалів</title>
    <meta name="description" content="Каталог фільмів та серіалів з категоріями, окремими сторінками та адмін-панеллю.">
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark site-navbar sticky-top">
    <div class="container">
        <a class="navbar-brand logo" href="index.php"><span>Movie</span>Space</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <?php foreach ($menus as $menu): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= esc($menu['link']); ?>"><?= esc($menu['title']); ?></a>
                    </li>
                <?php endforeach; ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Категорії</a>
                    <div class="dropdown-menu" aria-labelledby="categoryDropdown">
                        <?php foreach ($categories as $category): ?>
                            <a class="dropdown-item" href="category.php?category_id=<?= (int)$category['id']; ?>"><?= esc($category['name']); ?></a>
                        <?php endforeach; ?>
                    </div>
                </li>
            </ul>
            <form class="form-inline search-form" action="index.php" method="get">
                <input class="form-control mr-sm-2" type="search" name="q" placeholder="Пошук фільму..." aria-label="Search" value="<?= isset($_GET['q']) ? esc($_GET['q']) : ''; ?>">
                <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Знайти</button>
            </form>
            <a class="btn btn-warning ml-lg-3 auth-btn" href="login/index.php">Вхід</a>
        </div>
    </div>
</nav>
<main>
