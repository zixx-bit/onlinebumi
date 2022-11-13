<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once $_SERVER['DOCUMENT_ROOT'].'/online store/core/init.php';
if (!is_logged_in()) {
  login_error_redirect();
}
include 'includes/head.php';
include 'includes/navigation.php';

//get brands from Database
 $sql = $db->prepare("SELECT * FROM brand ORDER BY brand");
 // $sql->bind_param("s", brand);
 $sql->execute();
 $results = $sql->get_result();
 $errors = array();
 $messages = array();





 // edit brand
 if (isset($_GET['edit']) && !empty($_GET['edit'])) {
   $edit_id = (int)$_GET['edit'];
   $edit_id = sanitize($edit_id);
   $sql2 = $db->prepare("SELECT *  FROM brand WHERE id = ? ");
   $sql2->bind_param("i", $edit_id);
   $sql2->execute();
   $edit_result = $sql2->get_result();
   $eBrand = mysqli_fetch_assoc($edit_result);
   // $sql2->close();
 }

 // delete brand from Database
 if (isset($_GET['delete'])&& !empty($_GET['delete'])) {
$delete_id = (int)$_GET['delete'];
$delete_id = sanitize($delete_id);
$sql = $db->prepare("DELETE FROM brand where id = ?");
$sql->bind_param('i', $delete_id);
$sql->execute();
// $db->query($sql);
$_SESSION['success_flash'] = 'Brand deleted succesfully';

header("Location: brands.php");
$sql->close();
 }
 // if add form is submitted
 if (isset($_POST['add_submit'])){
   $brand = sanitize($_POST['brand']);
   // check if brand is blank
       if ($_POST['brand'] =='') {
         $errors[] .='You must enter a brand!';
       }

   // check if brand exists in Database
   $sql2 = $db->prepare("SELECT * FROM brand WHERE brand = ?");
   $sql2->bind_param("s", $brand);
       if (isset($_GET['edit'])) {
         $sql2 = $db->prepare("SELECT * FROM brand WHERE
           brand = ? AND id != ?");
         $sql2->bind_param("si", $brand, $edit_id);
       }
       $sql2->execute();
       $result =$sql2->get_result();
       $count = mysqli_num_rows($result);
             if ($count>0) {

              $errors[].=$brand.' already exists! Please choose another brand name.';
       }

  // display $errors
  if (!empty($errors)) {
    echo display_errors($errors);
  }
  else{
    // add brand to Database
    $sql3 = $db->prepare("INSERT INTO brand (brand)
     VALUES(?)");
    $sql3 -> bind_param("s", $brand);
    // $sql3->execute();
    $_SESSION['success_flash'] = 'Brand added succesfully';

    // $sql3->close();
    header('location: brands.php');

    if (isset($_GET['edit'])) {
      $sql3 = $db->prepare("UPDATE brand SET brand = ? WHERE id = ?");
      $sql3 -> bind_param("si", $brand, $edit_id);
      // $sql3 -> execute();
      $_SESSION['success_flash'] = "Brand edited succesfully :)";

      }
      $sql3->execute();
      $sql3 -> close();
      header('location: brands.php');
    }
}


 ?>


 <h2 class="text-center">Brand</h2>
 <hr>
 <!-- Brand form -->
 <div class="text-center">
   <form class="form-inline" action="brands.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:'');?>" method="post">
     <div class="form-group">
       <?php
       $brand_value = '';
       if (isset($_GET['edit'])) {
         $brand_value= $eBrand['brand'];
       }else {
         if (isset($_POST['brand'])) {
          $brand_value = sanitize($_POST['brand']);
         }
       }

        ?>
       <label for="brand"><?=((isset($_GET['edit']))?'Edit':'Add a ');?> Brand</label>
                                                                              <!-- if else in short form -->
       <input type="text" name="brand" id="brand" class="form-control" value="<?=$brand_value?>">
       <?php if (isset($_GET['edit'])): ?>
         <a href="brands.php" class="btn btn-default">Cancel</a>
       <?php endif; ?>
       <input type="submit" name="add_submit" value="<?=((isset($_GET['edit']))?'Edit':'Add');?> Brand" class="btn btn-success">
     </div>
   </form>
 </div>
 <hr>

 <table class="table table-bordered table-striped table-design">
   <thead>
     <th class="btn btn-xs btn-primary">Edit</th><th class="text-center" style="font-size:16px;">Brand</th><th class="btn btn-xs btn-danger">Delete</th>
   </thead>
     <tbody>
       <?php while ($brand = mysqli_fetch_assoc($results)) : ?>
          <tr>
            <td> <a href="brands.php?edit=<?php echo $brand['id']; ?>" class="btn btn-xs btn-default"> <span class="glyphicon glyphicon-pencil"></span> </a> </td>
            <td><?php echo $brand['brand']; ?></td>
            <td> <a href="brands.php?delete=<?php echo $brand['id']; ?>" class="btn btn-xs btn-default"> <span class="glyphicon glyphicon-remove-sign"></td>
          </tr>
        <?php endwhile; ?>
     </tbody>
 </table>
 <?php  include "includes/footer.php";?>
