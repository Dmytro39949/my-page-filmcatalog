<?php require_once __DIR__ . '/auth.php'; ?>
<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Адмін-панель MovieSpace</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark site-navbar">
    <div class="container">
        <a class="navbar-brand logo" href="index.php"><span>Movie</span>Space Admin</a>
        <div class="admin-nav-actions ml-auto">
            <a class="btn btn-outline-light admin-nav-link" href="../index.php">На сайт</a>
            <a class="btn btn-warning admin-nav-link" href="logout.php">Вийти</a>
        </div>
    </div>
</nav>
<main class="admin-page">
<div class="container">
