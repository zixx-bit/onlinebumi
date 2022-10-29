<?php

    require 'payments.php';
    header("Content-Type: application/json");

    $response = '{
      "ResultCode":0,
      "ResultDesc":"confirmation received succesfully"
    }';

    // DATA
    $mpesaResponse = file_get_contents('php://input');

    // log the response
    $logFile = "M_PESAConfirmationResponse.txt";
    $log  = fopen($logFile, "a");

    fwrite($log, $mpesaResponse);
    fclose($log);
    //
    // $jsonMpesaResponse = json_decode($mpesaResponse, true);
    //
    // $transaction  = array(
    //   'TransactionType'   => $jsonMpesaResponse['TransactionType'],
    //   'TransID'           => $jsonMpesaResponse['TransID'],
    //   'TransTime'         => $jsonMpesaResponse['TransTime'],
    //   'TransAmount'       => $jsonMpesaResponse['TransAmount'],
    //   'BusinessShortCode' => $jsonMpesaResponse['BusinessShortCode'],
    //   'BillRefNumber'     => $jsonMpesaResponse['BillRefNumber'],
    //   'InvoiceNumber'     => $jsonMpesaResponse['InvoiceNumber'],
    //   'OrgAccountBalance' => $jsonMpesaResponse['OrgAccountBalance'],
    //   'MSISDN'            => $jsonMpesaResponse['MSISDN'],
    //   'FirstName'         => $jsonMpesaResponse['FirstName'],
    //   'MiddleName'        => $jsonMpesaResponse['MiddleName'],
    //   'LastName'          => $jsonMpesaResponse['LastName'],
    // );
    //




    // write to file

    $log  = fopen($logFile, "a");

    fwrite($log, $mpesaResponse);
    fclose($log);

    echo $response;

    insert_response($transaction);


 ?>
