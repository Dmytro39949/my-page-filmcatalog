<?php
require_once __DIR__ . '/auth.php';
$post_id = isset($_GET['post_id']) ? $_GET['post_id'] : 0;
if (!is_numeric($post_id)) exit('Некоректний ідентифікатор запису');
delete_new($post_id);
header('Location: index.php');
exit();
?>
