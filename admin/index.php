<?php
require_once '../core/init.php';
if (!has_permission()) {
  permission_error_redirect('products.php');
}

if (!is_logged_in()) {
  header('Location: login.php');
}



include "includes/head.php";
include "includes/navigation.php";
// session_destroy();

 ?>
<?php
 // $txnQuery = "SELECT t.id, t.cart_id, t.full_name, t.description, t.txn_date, t.grand_total, c.items, c.paid, c.shipped
 // FROM transactions t
 // LEFT JOIN cart c ON t.cart_id = c.id
 // WHERE c.paid = 1 AND c.shipped = 0
 // ORDER BY t.txn_date";
 //
 // $txnResults = $db->query($txnQuery);
 $num_per_page = 3;

 if (isset($_GET["page"]))
  {
   // code...
   $page = $_GET["page"];
 }

 else {
   $page=1;
 }

 $start_from = ($page-1)*$num_per_page;

 $txnQuery = "SELECT t.id, t.cart_id, t.full_name, t.description, t.txn_date, t.grand_total, c.items, c.paid, c.shipped
 FROM transactions t
 LEFT JOIN cart c ON t.cart_id = c.id
 WHERE c.paid = 1 AND c.shipped = 0
 ORDER BY t.txn_date LIMIT $start_from, $num_per_page ";

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
   <h3 class="text-center" >Orders To Deliver</h3>
   <!-- id="oders_to_deliver"  -->
   <table class="table table-striped table-condensed table-bordered ">
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

   <?php

   $txnQuery = "SELECT t.id, t.cart_id, t.full_name, t.description, t.txn_date, t.grand_total, c.items, c.paid, c.shipped
   FROM transactions t
   LEFT JOIN cart c ON t.cart_id = c.id
   WHERE c.paid = 1 AND c.shipped = 0
   ORDER BY t.txn_date ";

    $txnResults = $db->query($txnQuery);


    $total_records = mysqli_num_rows($txnResults);
    $total_pages = ceil($total_records/$num_per_page);

    // echo $total_records;

   // echo $total_pages;

   if ($page>1) {
     echo "<a href='index.php?page=".($page-1)."' class='btn btn-sm btn-success' style='margin-right:5px;'><< Previous</a>";
   }

    for ($i=1; $i<=$total_pages; $i++ ) {
      // echo "<a href='index.php?page=".$i."' class='btn btn-success'>".$i."</a>";
      if ($page==$i) {
        echo  "<a href='index.php?page=".$i."' class='btn btn-sm btn-warning'>".$i."</a>"; ;
      }
       else {
        echo "<a href='index.php?page=".$i."' class='btn btn-sm btn-default' style='margin:2px;'>".$i."</a>";
      }

    }

    if ($i>$page) {
      echo "<a href='index.php?page=".($page+1)."' class='btn btn-sm btn-success' style='margin-left:5px;'>Next >></a>";
    }



    ?>

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
    <div class="col-md-4">
      <h3 class="text-center">Sales By Month</h3>
      <!-- <?= date("m-d-y m:i:s")?> -->
      <table class="table table-condensed table-bordered table-striped table-hover table-dark">
        <thead>

          <th></th>
          <th><?=$lastYr;?></th>
          <th><?=$thisYr;?></th>
          <th></th>

        </thead>
        <tbody>
          <?php for($i = 1; $i <= 12; $i++):
            $dt = DateTime::createFromFormat('!m',$i); ?>
          <tr >
            <td style=""><?=$dt->format("F");?></td>
            <td style="color:#475724;"><?=(array_key_exists($i, $last))?money($last[$i]):money(0);?></td>
            <td style="color:#475724;"><?=(array_key_exists($i, $current))?money($current[$i]):money(0);?></td>
            <td style=""> <a href="month_sales.php?month_id=<?=(array_key_exists($i, $current));?>" class="btn btn-xs btn-info"> Details</a> </td>

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

    <!-- low inventory -->
    <?php
    $iQuery = $db->query("SELECT * FROM products WHERE deleted = 0 ");
    $lowItems = array();
    while($product = mysqli_fetch_assoc($iQuery)){
      $image = $product['image'];
      $item = array();
      $sizes = sizesToArray($product['sizes']);
      foreach ($sizes as $size) {
        if ($size['quantity'] <= $size['threshold']) {


        $cat = get_category($product['categories']);
        $item = array(
          'title' => $product['title'],
          'size' => $size['size'],
          'quantity' => $size['quantity'],
          'threshold' => $size['threshold'],
          'category' => $cat['parent'].'~'.$cat['child'],
        );
        $lowItems[] = $item;
      }


    }
  }


     ?>
    <div class="col-md-8">
      <h3 class="text-center" id="low_inventory">
        Low Inventory</h3>
      <table class="table table-condensed table-bordered ">
        <thead>
          <th>Product</th>
          <!-- <th>Image</th> -->
          <th>Category</th>
          <th>Size</th>
          <th>Quantity</th>
          <th>Threshold</th>
        </thead>

        <tbody>
          <?php foreach($lowItems as $item):?>
          <tr
                <?php if ($item['quantity'] == 0): ?>
                  <div class="bg-danger text-danger">

                  </div>


              <?php elseif (($item['quantity'] <  ['threshold']) || ($item['quantity'] != ['threshold'])) :?>
                    <div class="bg-warning">

                    </div>


                  <?php else: ?>
                    <div class="bg-info">

                    </div>
                <?php endif; ?>

            <td><?=$item['title'];?></td>
            <!-- <td><img class="" id="img-thumb-2" src="<?=$image;?>"> </td> -->

            <td><?=$item['category'];?></td>
            <td><?=$item['size'];?></td>
            <td><?=$item['quantity'];?></td>
            <td><?=$item['threshold'];?></td>
          </tr>
        <?php endforeach;?>
        </tbody>

      </table>

    </div>



 <?php
  include "includes/footer.php";
  ?>

  <?php ?>
