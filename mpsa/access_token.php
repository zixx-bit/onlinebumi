<?php
  $consumerKey  = '3DpavJc4hJUxJWdMyb7vq6HxQAa1UUVT';
  $consumerSecret = 'TklqC7epHCCYBAGp';

  $headers = ['Content-Type:application/json; charset=utf8'];

  $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';




  $ch = curl_init($url);


  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_HEADER, FALSE);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_USERPWD, $consumerKey.':'.$consumerSecret);

  $result = curl_exec($ch);
  $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  $result = json_decode($result);

  $access_token = $result->access_token;

  echo $access_token;

  curl_close($ch);

  ?>
