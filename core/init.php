<?php
$db=mysqli_connect('localhost', 'bitray', '802neoKenya', 'store');
if (mysqli_connect_errno()) {
  echo 'Database connection failed with error: '. mysqli_connect_error();
  die();
}
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
require_once BASEURL.'helpers/helpers.php';
require BASEURL.'vendor/autoload.php';


$cart_id = '';
if (isset($_COOKIE[CART_COOKIE])) {
   $cart_id = sanitize($_COOKIE[CART_COOKIE]);
}




if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
    $query = $db->query("SELECT * FROM users WHERE id = '$user_id'");
    $user_data = mysqli_fetch_assoc($query);
    $full_name = explode(' ', $user_data['username']);
    $user_data['first'] = $full_name[0];
    // $user_data['last']  = $full_name[1];
}

if (isset($_SESSION['success_flash'])) {
    echo '<div class="bg-success"><p class="text-success text-center">'.$_SESSION['success_flash'].'</p></div>';
    unset($_SESSION['success_flash']);
}
if (isset($_SESSION['error_flash'])) {
    echo '<div class="bg-danger"><p class="text-danger text-center">'.$_SESSION['error_flash'].'</p></div>';
    unset($_SESSION['error_flash']);
}
// session_destroy();
