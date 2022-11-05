<?php
require_once '../core/init.php';
if (!is_logged_in()) {
  login_error_redirect();
}
if (!has_permission()) {
  permission_error_redirect('products.php');
}
include "includes/head.php";
include "includes/navigation.php";
if (isset($_GET['delete'])) {
  $delete_id = sanitize($_GET['delete']);
  $delete_user = $db->prepare("DELETE FROM verify WHERE id = ? ");
  $delete_user->bind_param("i", $delete_id);
  $delete_user->execute();
  $_SESSION['success_flash'] = 'User has been deleted';
  header('Location: users.php');
}
if (isset($_GET['add'])) {
  $name = ((isset($_POST['name']))?sanitize($_POST['name']):'');
  $email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
  $password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
  $confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
  $permissions = ((isset($_POST['permissions']))?sanitize($_POST['permissions']):'');
  $errors = array();
  if ($_POST) {
    $emailQuery = $db->prepare("SELECT * FROM users WHERE email = ? ");
    $emailQuery->bind_param("s", $email);
    $emailQuery->execute();
    $emailQ_fetched = $emailQuery->get_result();
    $emailCount = mysqli_num_rows($emailQ_fetched);
    if ($emailCount !=0) {
       $errors[] = 'Email already exists! Use a different email';
    }

    $required = array('name', 'email', 'password', 'confirm', 'permissions');
    foreach ($required as $f ) {
      if (empty($_POST[$f])) {
        $errors[] = 'You must fill out all fields';
        break;
      }
    }

    if (strlen($password) < 6) {
      $errors [] = 'Password must be atleast 6 characters';
    }

    if ($password != $confirm) {
      $errors [] = 'Passwords do not match';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors[] = 'You must enter a valid email address';
    }


    if (!empty($errors)) {
      echo display_errors($errors);
    }
    else {
      // add user to databse
      $hashed = password_hash($password, PASSWORD_DEFAULT);
      $add_user = $db->prepare("INSERT INTO users (full_name,email,password,permissions)
      Values (?, ?, ?, ?)");
        $add_user->bind_param("ssss", $name, $email, $hashed, $permissions);
        $add_user->execute();
        if ($add_user->execute() == true) {
          $_SESSION['success_flash'] = ' New user added :)';
          header('Location: users.php');
        }else {
          $_SESSION['error_flash'] = ' No user added! Try again';
          header('Location: users.php');
        }

    }
  }


  ?>
<h2 class="text-center"> <?=((isset($_GET['edit']))?'Edit':'Add a new');?>user</h2><hr>
<form class="" action="users.php<?=((isset($_GET['edit']))?'?edit':'?add=1');?>" method="post" >
  <div class="form-group col-md-6">
    <label for="name">Full Name:</label>
    <input type="text" name="name" id="name" class="form-control"
     value="<?=$name;?>">
      </div>

  <div class="form-group col-md-6">
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" class="form-control"
     value="<?=$email;?>">
      </div>

  <div class="form-group col-md-6">
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" class="form-control"
    value="<?=$password;?>">
      </div>

  <div class="form-group col-md-6">
    <label for="confirm">Confirm Password:</label>
    <input type="password" name="confirm" id="confirm" class="form-control"
     value="<?=$confirm;?>">
      </div>

  <div class="form-group col-md-6">
    <label for="permissions">Permissions:</label>
    <select class="form-control" name="permissions">
      <option value=""<?=(($permissions == '')?' selected':'' );?>></option>
      <option value="editor"<?=(($permissions =='editor')?' selected':'' );?>>Editor</option>
      <option value="admin,editor"<?=(($permissions =='admin, editor')?' selected':'' );?>>Admin</option>
    </select>
      </div>

  <div class="form-group col-md-6 text-right " style="margin-top:25px;">
    <a href="users.php" class="btn btn-default">Cancel</a>
    <input type="submit"  value="Add user" class="btn btn-primary">
  </div>
</form>

  <?php
}else{
$userQuery = $db->query("SELECT * FROM users ORDER BY full_name");

 ?>

 <h2>Users</h2>
 <div class="pull-right">
   <a href="users.php" class="btn btn-default " id="add-product-btn">Cancel</a>

   <a href="users.php<?=((isset($_GET['edit']))?'?Edit':'?add=1');?>" class="btn btn-success" id="add-product-btn"><?=((isset($_GET['edit']))?'Edit':'Add New')?> User</a>
 </div>

<hr>
 <table class="table table-bordered table-stripped table-condensed">
   <thead> <th></th><th>Name</th> <th>Email</th> <th>Join Date</th><th>Last Login</th><th>Permissions</th>
     <tbody>
       <?php while ($user = mysqli_fetch_assoc($userQuery)):?>
       <tr>
         <td> <?php if ($user['id'] != $user_data['id']):?>
           <a href="users.php?delete=<?=$user['id'];?>" class="btn btn-default btn-xs "><span class="glyphicon glyphicon-remove-sign" style2w54g></span></a>

              <a href="users.php?edit=<?=$user['id'];?>" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
               <?php endif; ?>
            </td>

         <td><?=$user['full_name'];?></td>
         <td><?=$user['email'];?></td>
         <td><?=pretty_date($user[
           'join_date']);?></td>
         <td><?= (($user['last_login'] == '0000-00-00 00:00:00')? 'Never':pretty_date($user['last_login']));?></td>
         <td><?=$user['permissions'];?></td>
       </tr>
     <?php endwhile;?>
     </tbody>

   </thead>

 </table>


<?php }
  include "includes/footer.php";
  ?>
