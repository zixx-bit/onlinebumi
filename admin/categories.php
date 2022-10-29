<?php
     require_once $_SERVER['DOCUMENT_ROOT']. '/core/init.php';
     if (!is_logged_in()) {
       login_error_redirect();
     }

     include 'includes/head.php';
     include 'includes/navigation.php';

     $parent = 0;
     $sql = $db->prepare("SELECT * FROM  categories WHERE parent = ?");
     $sql->bind_param("i", $parent);
     $sql->execute();
     $result = $sql->get_result();
     $errors = array();
     $messages = array();
     $category = '';
     $post_parent = '';

     // Edit Category
     if (isset($_GET['edit']) && !empty($_GET['edit'])) {
       $edit_id = (int)$_GET['edit'];
       $edit_id = sanitize($edit_id);
       $edit_sql = $db->prepare("SELECT * FROM categories WHERE id = ?");
       $edit_sql->bind_param("i", $edit_id);
       $edit_sql->execute();
       $edit_result = $edit_sql->get_result();
       $category_edit = mysqli_fetch_assoc($edit_result);
       $edit_sql->close();
       // $_SESSION['success_flash'] = "Edited succesfully";

     }

// Delete Category
    if (isset($_GET['delete']) && !empty($_GET['delete'])) {
      $delete_id = (int)$_GET['delete'];
      $delete_id = sanitize($delete_id);
      $sql = $db->prepare( "SELECT * FROM categories WHERE id= ? ");
      $sql->bind_param("i", $delete_id);
      $sql->execute();
      $result = $sql->get_result();
      $category = mysqli_fetch_assoc($result);
      if ($category['parent'] == 0) {
        $sql = $db->prepare("DELETE FROM categories WHERE parent = ? ");
        $sql->bind_param("i", $delete_id);
        $sql->execute();
        // $db->query($sql);
        $sql->close();
      }
      $dsql = $db->prepare("DELETE FROM categories WHERE id = ?");
      $dsql->bind_param("i", $delete_id);
      $dsql->execute();
      $dsql->close();
      $_SESSION['success_flash'] = "Category Deleted succesfully";

      header('Location: categories.php');
    }

// process form
     if (isset($_POST) && !empty($_POST)) {
      $post_parent = sanitize($_POST['parent']);
      $category  = sanitize($_POST['category']);
      $sqlform = $db->prepare("SELECT * FROM categories WHERE
         category = ? AND parent = ? ");
      $sqlform->bind_param("si", $category, $post_parent);
    if (isset($_GET['edit'])) {
        $id = $category_edit['id'];
        $sqlform = $db->prepare("SELECT * FROM categories WHERE
           category = ?  AND parent = ?  AND id != ? ");
        $sqlform->bind_param("sii",$category, $post_parent, $id);
    }

      $sqlform->execute();
      $fresult = $sqlform->get_result();
      $count = mysqli_num_rows($fresult);

// if category is blank
      if ($category == '') {
        $errors[].='The category cannot be left blank';
      }
      // if category exisist in Database
      if ($count > 0) {
        $errors[].=$category. ' already exists in the database. Insert another category';
      }
      // Display errors or update Database
      if (!empty($errors)) {
        // Display $errors
        $display = display_errors($errors);
        ?>


      <?php } else {
        // Update databse.
        $updateSql = $db->prepare("INSERT INTO categories (category, parent)
         VALUES(?, ?)");
         $updateSql->bind_param("si", $category, $post_parent);
         $_SESSION['success_flash'] = 'Category has been added successfully';


        if (isset($_GET['edit'])) {
          $updateSql = $db->prepare("UPDATE  categories SET category = ? , parent = ?  WHERE id = ? ");
          $updateSql->bind_param("sii",$category,$post_parent,$edit_id);

          $_SESSION['success_flash'] = 'Category has been edited successfully';
        }
        $updateSql->execute();
        $updateSql->close();
        // $db->query($updateSql);
        // $display2 = successMessage($messages);
        // $_SESSION['success_flash'] = "Deleted succesfully";


        header('Location: categories.php');
      }
}
    $category_value ='';
    $parent_value = 0;
    if (isset($_GET['edit'])) {
      $category_value = $category_edit['category'];
      $parent_value = $category_edit['parent'];
    }else {
    if (isset($_POST) ) {
      $category_value = $category;
      $parent_value = $post_parent;
        }
    }
 ?>

     <h2 class="text-center">Categories</h2><hr>
     <div class="row">

       <!-- Form -->
       <div class="col-md-6">
         <form class="form" action="categories.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:'');?>" method="post">
           <legend><?=((isset($_GET['edit'])?'Edit':'Add A'));?> Category</legend>
           <div id="errors"> </div>
           <div id="successMessage"> </div>

           <div class="form-group">
             <label for="parent">Parent</label>
             <select class="form-control" name="parent" id="parent">
               <option value="0"<?=(($parent_value == 0)?' selected="selected"':'');?>>Parent</option>
               <?php while ($parent =mysqli_fetch_assoc($result)):  ?>
                 <option value="<?php echo $parent['id'];?>"<?=(($parent_value == $parent['id'])?' selected="selected"':''); ?>><?php echo $parent['category']; ?></option>
               <?php endwhile; ?>
               </select>
           </div>

           <div class="form-group">
             <label for="category">Category</label>
             <input type="text" class="form-control" name="category" id="category" value="<?php echo $category_value; ?>">
             </div>

             <div class="form-group">
               <input type="submit" class="btn btn-success" value="<?=((isset($_GET['edit']))?'Edit':'Add');?> Category">
             </div>

         </form>
       </div>


       <div class="col-md-6">
         <table class="table table-bordered">
           <thead>
             <th>Category</th> <th>Parent</th> <th>Edit</th> <th>Deleteld</th>
           </thead>
           <tbody>
             <?php
             $parent=0;
             $sql = $db->prepare("SELECT * FROM  categories WHERE parent = ?");
             $sql->bind_param("i", $parent);
             $sql->execute();
             $result = $sql->get_result();
             // $result = $db->query($sql);

              while($parent = mysqli_fetch_assoc($result)):
               $parent_id =  $parent['id'];
                $sql2 =$db->prepare("SELECT * FROM categories WHERE parent = ? ");
                $sql2->bind_param("i",$parent_id);
                $sql2->execute();
                $cresult = $sql2->get_result();
                ?>
             <tr class="bg-primary">
               <td><?php echo $parent['category']; ?></td>
               <td>Parent</td>
               <td>
                 <a href="categories.php?edit=<?php echo $parent['id']; ?>" class="btn btn-xs btn-default"> <span class="glyphicon glyphicon-pencil"></span> </a>

               </td>
               <td>
                 <a href="categories.php?delete=<?php echo $parent['id']; ?>" class="btn btn-xs btn-default"> <span class="glyphicon glyphicon-remove-sign"></span> </a>

               </td>
             </tr>
             <?php while ($child = mysqli_fetch_assoc($cresult)):  ?>
             <tr class="bg-info">
               <td><?php echo $child['category']; ?></td>
               <td><?php echo $parent['category']; ?></td>
               <td>
                 <a href="categories.php?edit=<?php echo $child['id']; ?>" class="btn btn-xs btn-default"> <span class="glyphicon glyphicon-pencil"></span> </a>

               </td>
               <td>                 <a href="categories.php?delete=<?php echo $child['id']; ?>" class="btn btn-xs btn-default"> <span class="glyphicon glyphicon-remove-sign"></span> </a>
</td>

             </tr>
           <?php endwhile; ?>
           <?php endwhile; ?>
           </tbody>

         </table>
       </div>

     </div>

 <?php include 'includes/footer.php'; ?>
