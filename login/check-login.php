<?php
$login = 'admin';
$pass = '123';

if (isset($_POST['login'], $_POST['password']) && $login === $_POST['login'] && $pass === $_POST['password']) {
    session_start();
    $_SESSION['login'] = $_POST['login'];
    $_SESSION['password'] = $_POST['password'];
    header('Location: ../admin/index.php');
    exit();
}

header('Location: index.php');
exit();
?>
