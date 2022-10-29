<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/core/init.php';
if (!is_logged_in()) {
  login_error_redirect();
}
include 'includes/head.php';
include 'includes/navigation.php';
$errors = array();


$archiveSql = "SELECT * FROM products where deleted=1";
$productResults = $db->query($archiveSql);
// $product=mysqli_fetch_assoc($results);


if (isset($_GET['restore'])) {
  $archive_id = sanitize($_GET['restore']);
  $archivedSql= "UPDATE products SET deleted = 0 WHERE id = '$archive_id' ";
  $db->query($archivedSql);
  header('Location: archived.php');
  $_SESSION['success_flash'] = "Product restored successfully :) Check in the products page";
}
if (isset($_GET['delete'])) {
  $delete_id = sanitize($_GET['delete']);

  $deleteQuery = "DELETE FROM products WHERE id = '$delete_id'";
  $db->query($deleteQuery);
  header('Location: archived.php');
  $_SESSION['success_flash'] = "Product deleted from database!";

}


?>


<h2 class="text-center">Archived Products</h2>
<hr>
<table class="table table-bordered table-condensed table-striped">
  <thead>
    <th></th>
    <th>Product</th>
    <th>Price</th>
    <th>category</th>
    <th>Sold</th>
  </thead>

  <tbody>
    <?php while ($product = mysqli_fetch_assoc($productResults)) :
      $childID = $product['categories'];
      $catSql = "SELECT * FROM categories WHERE id = '$childID'";
      $result = $db->query($catSql);
      $child = mysqli_fetch_assoc($result);
      $parentID = $child['parent'];
      $pSql = "SELECT * FROM categories WHERE id = '$parentID'";
      $presult = $db->query($pSql);
      $parent = mysqli_fetch_assoc($presult);
      $category = $parent['category'].'~'.$child['category'];
      ?>


  <tr>
    <td>
      <a href="archived.php?restore=<?php echo $product['id']; ?>" class="btn btn-xs btn-default"> <span class="glyphicon glyphicon-refresh" name="restore"></span> </a>
      <a onclick="remove_alert" href="archived.php?delete=<?php echo $product['id'];?>" class="btn btn-xs btn-default"> <span class="glyphicon glyphicon-remove" ></span> </a>
    </td>
    <td><?php echo $product['title']; ?></td>
    <td><?php echo money($product['price']); ?></td>
    <td><?php echo $category; ?></td>

    <td>0</td>
  </tr>
<?php endwhile; ?>
  </tbody>
</table>


<?php include 'includes/footer.php'; ?>

<script>
 function remove_alert(){
 alert(" You are about to delete the product completely. this action cannot be undone");
 }

</script>
