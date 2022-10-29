<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/core/init.php';
$name = sanitize($_POST['full_name']);
$email = sanitize($_POST['email']);
$street = sanitize($_POST['street']);
$street2 = sanitize($_POST['street2']);
$city = sanitize($_POST['city']);
$state = sanitize($_POST['state']);
$zip_code = sanitize($_POST['zip_code']);
$country = sanitize($_POST['country']);

$errors = array();

$required = array(

   'full_name' => 'Full Name',
   'email'     => 'Email',
   'street'    => 'Street',
   'street'    => 'Mpesa paying phone number',
   'city'      => 'County',
   'state'     => 'Estate, Apartment, Suite, etc',
   'zip_code'  => 'Business name or House no',
   'country'   => 'Country',

);

// check if reuired fields are filled out
foreach ($required as $f => $d) {
  if (empty($_POST[$f])  || $_POST[$f] == '') {
     $errors [] = $d. '  is required';
  }
}

// check if email address is valid
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $errors[] = 'Please enter a valid email';
}

if(!empty($errors)){
  echo display_errors($errors);
}else{
  echo true;
}
