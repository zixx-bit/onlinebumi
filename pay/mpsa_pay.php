<?php
require_once '../core/init.php';


header("Content-Type:application/json");
// session_start();

$config = array(
    "env"              => "sandbox",
    "BusinessShortCode"=> "174379",
    "key"              => "3DpavJc4hJUxJWdMyb7vq6HxQAa1UUVT", //Enter your consumer key here
    "secret"           => "TklqC7epHCCYBAGp", //Enter your consumer secret here
    "username"         => "apitest",
    "TransactionType"  => "CustomerPayBillOnline",
    "passkey"          => "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919", //Enter your passkey here
    "CallBackURL"     => "https://www.bitray.tech/online%20store/pay/callback_url.php",
    "AccountReference" => "Bitray",
    "TransactionDesc"  => "Payment of subscription" ,
);

$phone = $_GET['phone'];
$total_pay = (int)$_GET['total'];

// $_POST['phone'] = "254769212991";

// if (isset($_POST['submit'])) {

    // $phone = $_POST['phone'];
    $amount = $total_pay;

    $phone = (substr($phone, 0, 1) == "+") ? str_replace("+", "", $phone) : $phone;
    $phone = (substr($phone, 0, 1) == "0") ? preg_replace("/^0/", "254", $phone) : $phone;
    $phone = (substr($phone, 0, 1) == "7") ? "254{$phone}" : $phone;

    $access_token = ($config['env']  == "live") ? "https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials" :
     "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
    $credentials = base64_encode($config['key'] . ':' . $config['secret']);

    $ch = curl_init($access_token);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Basic " . $credentials]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($response);
    $token = isset($result->{'access_token'}) ? $result->{'access_token'} : "N/A";

    $timestamp = date("YmdHis");
    $password  = base64_encode($config['BusinessShortCode'] . "" . $config['passkey'] ."". $timestamp);

    $curl_post_data = array(
        "BusinessShortCode" => $config['BusinessShortCode'],
        "Password" => $password,
        "Timestamp" => $timestamp,
        "TransactionType" => $config['TransactionType'],
        "Amount" => $amount,
        "PartyA" => $phone,
        "PartyB" => $config['BusinessShortCode'],
        "PhoneNumber" => $phone,
        "CallBackURL" => $config['CallBackURL'],
        "AccountReference" => $config['AccountReference'],
        "TransactionDesc" => $config['TransactionDesc'],
    );

    $data_string = json_encode($curl_post_data);

    $endpoint = ($config['env'] == "live") ? "https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest" :
     "https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest";

    $ch = curl_init($endpoint );
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer '.$token,
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response   = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response);

    $verified = $result->{'ResponseCode'};






?>
<?php

header("Location: callback_url.php");

 ?>
