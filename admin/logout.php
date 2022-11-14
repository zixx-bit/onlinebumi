<?php
require_once $_SERVER['DOCUMENT_ROOT']. '/online store/core/init.php';
unset($_SESSION['id']);
header('Location: ../verify/login.php');
?>
