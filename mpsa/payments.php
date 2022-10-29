<?php

    require '../core/init.php';

    function insert_response($jsonMpesaResponse){
      try {
        $insert =  ("INSERT INTO `mpesa_payments`( `TransactionType`, `TransID`,
           `TransTime`,
           `TransAmount`, `BusinessShortCode`, `BillRefNumber`, `InvoiceNumber`,
            `OrgAccountBalance`,
            `ThirdPartyTransID`, `MSISDN`, `FirstName`, `MiddleName`, `LastName`)
        VALUES
        (TransactionType, TransID, TransTime, TransAmount, BusinessShortCode, BillRefNumber, InvoiceNumber, OrgAccountBalance,
          ThirdPartyTransID, MSISDN, FirstName, MiddleName, LastName)");
          $insert->execute((array)($jsonMpesaResponse ));

      } catch (PDOException $e) {
        $errLog = fopen('error.txt', 'a');
        fwrite($errLog, $e->getMessage());
        fclose($errLog);

        $logFailedTransaction = fopen('failedTransaction.txt', 'a');
        fwrite($logFailedTransaction, json_encode($jsonMpesaResponse));
        fclose($logFailedTransaction);
      }

    }


 ?>
