<?php
session_start();
require_once __DIR__ . '/../include/functions.php';

if (!admin_is_logged_in()) {
    header('Location: ../login/index.php');
    exit();
}
?>
