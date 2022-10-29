<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/online store/core/init.php';
if (!is_logged_in()) {
  login_error_redirect();
}
if (!has_permission()) {
  permission_error_redirect('index.php');
}

include 'includes/head.php';
include 'includes/navigation.php';
?>

 <!-- Inventory -->
<?php
$iQuery = $db->query("SELECT * FROM products WHERE deleted = 0 ORDER BY title ");
$Items = array();
while($product = mysqli_fetch_assoc($iQuery)){
  $item = array();
  $sizes = sizesToArray($product['sizes']);
  foreach ($sizes as $size) {

    $cat = get_category($product['categories']);
    $item = array(
      'title' => $product['title'],
      'size' => $size['size'],
      'quantity' => $size['quantity'],
      'threshold' => $size['threshold'],
      'category' => $cat['parent'].'~'.$cat['child'],
    );
    $Items[] = $item;
  }

}

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

$txnQuery = "SELECT * FROM products WHERE deleted = 0 ORDER BY title $start_from, $num_per_page ";

 $txnResults = $db->query($txnQuery);



 ?>
<div class="col-md-12">
  <h3 class="text-center">Inventory</h3>





  <table class="table table-condensed table-bordered table-striped">
    <thead>
      <th>Products</th>
      <th>Category</th>
      <th>Size</th>
      <th>Quantity</th>
      <th>Threshold</th>
    </thead>

    <tbody>
      <?php foreach($Items as $item):?>
      <tr  >
        <td><?=$item['title'];?></td>
        <td><?=$item['category'];?></td>
        <td><?=$item['size'];?></td>
        <td><?=$item['quantity'];?></td>
        <td><?=$item['threshold'];?></td>
      </tr>
    <?php endforeach;?>
    </tbody>

  </table>

  <?php
       $sql= "SELECT * FROM products WHERE deleted = 0 ORDER BY title ";

       $featured = $db->query($sql);



        $total_records = mysqli_num_rows($featured);
        $total_pages = ceil($total_records/$num_per_page);

        // echo $total_records;

       // echo $total_pages;

       if ($page>1) {
         echo "<a href='inventory.php?page=".($page-1)."' class='btn btn-sm btn-info' style='margin-right:5px;'> << Previous</a>";
       }

        for ($i=1; $i<$total_pages; $i++ ) {
          // echo "<a href='index.php?page=".$i."' class='btn btn-success'>".$i."</a>";
          if ($page==$i) {
            echo  "<a href='inventory.php?page=".$i."' class='btn btn-sm btn-warning'>".$i."</a>"; ;
          }
           else {
            echo "<a href='inventory.php?page=".$i."' class='btn btn-sm btn-default' style='margin:2px;'>".$i."</a>";
          }

        }

        if ($i>$page) {
          echo "<a href='inventory.php?page=".($page+1)."' class='btn btn-sm btn-info' style='margin-left:5px;'>Next >></a>";
        }

 ?>
</div>



<?php
include "includes/footer.php";
?>
