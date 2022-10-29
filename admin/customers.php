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
 $CustomersQuery = "SELECT * FROM transactions ORDER BY full_name";

 $customerResults = $db->query($CustomersQuery);

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
   <h3 class="text-center" >Customers</h3>
   <!-- id="oders_to_deliver"  -->
   <table class="table table-condensed table-bordered table-striped ">
     <thead>
       <th></th> <th>Name</th> <th>Email</th>  <th>Phone</th> <th>Location</th>
     </thead>

     <tbody>
        <?php while ($customer = mysqli_fetch_assoc($customerResults)): ?>
       <tr>
         <td><?=$customer['id'];?></td>
         <td><?=$customer['full_name'];?></td>
         <td><?=$customer['email'];?></td>
         <td><?=$customer['street2'];?></td>
         <td><?=$customer['state'];?></td>
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
