<?php

$to = "0702668083@safaricom.com";
$from = "eddmichira@bitray.tech"; // email from a working web server
$message = "This is a text message from Edd \n New line ...";
$headers = "From : $from\n";
mail($to, '', $message, $headers);
 ?>
