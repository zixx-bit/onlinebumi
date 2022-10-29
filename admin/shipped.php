<?php
require_once '../core/init.php';
if (!is_logged_in()) {
  header('Location: login.php');
}
if (!has_permission()) {
  permission_error_redirect('index.php');
}


include "includes/head.php";
include "includes/navigation.php";
// session_destroy();

 ?>
<?php
 $txnQuery = "SELECT t.id, t.cart_id, t.full_name, t.description, t.txn_date, t.grand_total, c.items, c.paid, c.shipped
 FROM transactions t
 LEFT JOIN cart c ON t.cart_id = c.id
 WHERE c.paid = 1 AND c.shipped = 1
 ORDER BY t.txn_date";

 $txnResults = $db->query($txnQuery);

 ?>
 <style media="screen">
   /* body{

     background-image:linear-gradient(rgba(0,0,0,0.8),rgba(0,0,0,0.8)), url("/online store/images/headerlogo/background.jpg");
     background-size: 100vw 100vh;
     background-attachment: fixed;
     color: #fff;

   } */
 </style>
 <div class="col-md-12">
   <h3 class="text-center" >Orders Shippedr</h3>
   <!-- id="oders_to_deliver"  -->
   <table class="table table-condensed table-bordered ">
     <thead>
       <th></th> <th>Name</th> <th>Description</th> <th>Total</th> <th>Date of order placement</th>
     </thead>

     <tbody>
        <?php while ($order = mysqli_fetch_assoc($txnResults)): ?>
       <tr>
         <td> <a href="orders.php?txn_id=<?=$order['id'];?>" class="btn btn-xs btn-info"> Details </a> </td>
         <td><?=$order['full_name'];?></td>
         <td><?=$order['description'];?></td>
         <td><?=money($order['grand_total']);?></td>
         <td><?=pretty_date($order['txn_date']);?></td>
       </tr>
     <?php endwhile; ?>
     </tbody>

   </table>

 </div>


  <!-- sales ny month -->
  <div class="row">
    <!-- sales by month -->
    <?php
    $thisYr = date("Y");
    $lastYr = $thisYr - 1;
    $thisYrQ = $db->query("SELECT grand_total, txn_date FROM transactions WHERE YEAR(txn_date) = '{$thisYr}'");
    $lastYrQ = $db->query("SELECT grand_total, txn_date FROM transactions WHERE YEAR(txn_date) = '{$lastYr}'");
    $current =array();
    $last =array();
    $currentTotal = 0;
    $lastTotal = 0;


    for ($month=1; $month <=12 ; $month++) {
    $last[(INT)$month] = 0;
    $current[(INT)$month] = 0;
   }

   while ($x = mysqli_fetch_assoc($thisYrQ)) {
    $month = date("m", strtotime($x['txn_date'])) .' ';
    $current[(INT)$month] += $x['grand_total'];
    $currentTotal += $x['grand_total'];
   }

   while ($y = mysqli_fetch_assoc($lastYrQ)) {
    $month = date("m", strtotime($y['txn_date'])) .' ';
    $last[(INT)$month] += $y['grand_total'];
    $lastTotal += $y['grand_total'];
   }


    // while ($x = mysqli_fetch_assoc($thisYrQ)) {
    //   // code...
    //   $month = date("m", strtotime($x['txn_date']));
    //   if (!array_key_exists($month, $current)) {
    //     // code...
    //     $current[(int)$month] = $x['grand_total'];
    //   }else{
    //     $current[(int)$month] = $x['grand_total'];
    //   }
    //   $currentTotal += $x['grand_total'];
    // }
    //
    // while ($y = mysqli_fetch_assoc($lastYrQ)) {
    //   // code...
    //   $month = date("m", strtotime($y['txn_date']));
    //   if (!array_key_exists($month, $last)) {
    //     // code...
    //     $last[(int)$month] = $y['grand_total'];
    //   }else{
    //     $last[(int)$month] = $y['grand_total'];
    //   }
    //   $lastTotal += $y['grand_total'];
    // }
    ?>

 <?php
  include "includes/footer.php";
  ?>

  <?php ?>
