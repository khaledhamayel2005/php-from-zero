<?php
session_start();
$_SESSION = array();
session_destroy();
header('Location: products.php');
exit;
?>
