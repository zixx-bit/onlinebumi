<?php
      require_once $_SERVER['DOCUMENT_ROOT']. '/online store/core/init.php';
      if (!is_logged_in()) {
       login_error_redirect();
      }
      if (!has_permission()) {
        permission_error_redirect('index.php');
      }


include "includes/head.php";
include 'includes/navigation.php';
    $mpesa_sql = $db->query("SELECT *  FROM payments WHERE ResultCode = 0");
    // ($mpesa_sql);


 ?>

<div class="col-md-8">
<h3 class="text-center text-success"> <strong >M-Pesa payments</strong> </h3>
<hr>
 <table class="table table-condensed table-striped table-bordered">
   <thead>
     <th>ID </th> <th>CheckoutRequestID</th> <th>MpesaReceiptNumber</th> <th>Amount</th> <th>PhoneNumber</th> <th> TransactionTime</th>

   </thead>
   <tbody>
      <?php while($pay = mysqli_fetch_assoc($mpesa_sql)): ?>
     <tr>
       <td></td>
       <td><?=$pay['CheckoutRequestID'];?></td>
       <td><?=$pay['MpesaReceiptNumber'];?></td>
       <td><?=money($pay['amount']);?></td>
       <td><?=$pay['PhoneNumber'];?></td>
       <td><?= $pay['TransactionTime'];?></td>
     </tr>
   <?php endwhile; ?>
   </tbody>
 </table>
</div>
