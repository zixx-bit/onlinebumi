<?php



$consumerKey  = '3DpavJc4hJUxJWdMyb7vq6HxQAa1UUVT';
$consumerSecret = 'TklqC7epHCCYBAGp';

$headers = ['Content-Type:application/json; charset=utf8'];

$acess_token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';




$ch = curl_init($acess_token_url);


curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_USERPWD, $consumerKey.':'.$consumerSecret);

$result = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$result = json_decode($result);

$access_token = $result->access_token;

echo $access_token;



$url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl';

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json' , 'Authorization:Bearer '.$access_token));

$curl_post_data = array(
  'ShortCode' => '600987',
  'ResponseType' => 'Completed',
  'ConfirmationURL'  => 'https://www.shawk.space/online%20store/mpsa/confirmation_url.php',
  'ValidationURL'  => 'https://www.shawk.space/online%20store/mpsa/validation.php'

   );

$data_string = json_encode($curl_post_data);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

$curl_response = curl_exec($curl);
print_r($curl_response);

echo $curl_response;


 ?>
