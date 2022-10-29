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

 <!-- sales ny month -->
 <div class="row">
   <!-- sales by month -->
   <?php
   $thisMonth = date("M");
   // $lastMonth = $thisMonth - 1;
   $thisMQ = $db->query("SELECT grand_total, txn_date FROM transactions WHERE date(txn_date) =  '{$thisMonth} GROUP BY ");
   // $lastMQ = $db->query("SELECT grand_total, txn_date FROM transactions WHERE MONTH(txn_date) = '{$lastYr}'");
   var_dump($thisMQ);

   $current = array();
   // $last = array();
   $currentTotal = 0;
   // $lastTotal = 0;


   for ($day=1; $day <=35 ; $day++) {
   // $last[(INT)$day] = 0;
   $current[(INT)$day] = 0;
  }

  while ($x = mysqli_fetch_assoc($thisMQ)) {
   $day = date("d", strtotime($x['txn_date'])) .' ';
   $current[(INT)$day] += $x['grand_total'];
   $currentTotal += $x['grand_total'];
  }

?>


<div class="col-md-8">
  <h3 class="text-center">Sales By Day</h3>
  <?= date("m-d-y m:i:s")?>
  <table class="table table-condensed table-bordered table-striped table-hover table-dark">
    <thead>

      <th></th>
      <th><?=$thisMonth;?></th>
      <th></th>

    </thead>
    <tbody>
      <?php for($i = 1; $i <= 31; $i++):

        // $dt = Date('!d', $i);
        $dt =  new(DateTime::createFromFormat('!d',$i)) ;
          ?>
      <tr >
        <td style=""><?=date( "l jS \of F Y", );?></td>
        <!-- <td style="color:#475724;"><?=(array_key_exists($i, $last))?money($last[$i]):money(0);?></td> -->
        <td style="color:#475724;"><?=(array_key_exists($i, $current))?money($current[$i]):money(0);?></td>
        <!-- <td style=""> <a href="orders.php?txn_id=<?=$order['id'];?>" class="btn btn-xs btn-info"> Details</a> </td> -->

      </tr>
    <?php endfor;?>

    <tr>
      <td style="font-weight:bold;">Total</td>
      <td  style="color:#475724; font-weight:bold;"><?=money($lastTotal);?></td>
      <td  style="color:#475724; font-weight:bold;"><?=money($currentTotal);?></td>
    </tr>
    </tbody>
  </table>

</div>
