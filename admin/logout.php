<?php
require_once $_SERVER['DOCUMENT_ROOT']. '/online store/core/init.php';
unset($_SESSION['id']);
unset($_SESSION['username']);
unset($_SESSION['email']);
unset($_SESSION['verify']);
header('Location: ../verify/login.php');
