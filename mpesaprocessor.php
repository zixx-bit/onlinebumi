<?php
// include "cart.php";

date_default_timezone_set('Africa/Nairobi');

  // if (isset($_GET[$grand_total])) {
  //   stkPush($_GET[$grand_total]);
  //
  //   }

  function lipaNaMpesaPassword()
  {
    //timestamp
    $timestamp = date('YmdHis');

    //passkey
    $passkey ="bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
    $businessShortCode = 174379;
    //generate password
    $mpesaPassword = base64_encode($businessShortCode.$passkey.$timestamp);

    return $mpesaPassword;

  }

       echo $timestamp;

  function newAccessToken()
  {
    $consumer_key =" 3DpavJc4hJUxJWdMyb7vq6HxQAa1UUVT";
    $consumer_secret = "TklqC7epHCCYBAGp";
    $credentials = base64_encode($consumer_key.":".$consumer_secret);
    $url = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";


    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Basic".$credentials));
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $curl_response = curl_exec($curl);
    $access_token = json_decode($curl_response);
    curl_close($curl);

  }

  function stkPush ($amount)
  {
    $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
    $curl_post_data = [
      'BusinessShortCode' => 174379,
      'Password' => lipaNaMpesaPassword(),
      'Timestamp' => $timestamp,
      'TransactionType' => 'CustomerBuyGoodsOnline',
      'Amount' => $amount,
      'PartyA'  => "254702668083",
      'PartyB' => 174379,
      'PhoneNumber' => "254702668083",
      'CallBackURL' => 'http://a0a8-41-80-98-237.ngrok.io/online%20store/mpesaprocessor.php',
      'AccountReference' => "Edd Shop",
      'TransactionDesc' => "lipa Na Mpesa"
    ];

    $data_string = json_encode($curl_post_data);


        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer'.newAccessToken()));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $curl_response = curl_exec($curl);
        print_r($curl_response);


  }

?>
