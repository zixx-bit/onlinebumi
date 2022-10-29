
<?php

 require_once $_SERVER['DOCUMENT_ROOT']. '/online store/core/init.php';
// if (!is_logged_in()) {
//   login_error_redirect();
// }
 include 'includes/head.php';
 $name ="";
 $email ="";
 $password ="";
 $confirm ="";
 $permissions = "";

 if (isset($_GET['signUp-btn'])) {
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
           $_SESSION['success_flash'] = ' Sign up succesfull. Try  to login in';
           header('Location: login2.php');
         }else {
           $_SESSION['error_flash'] = ' Sign up failed! Try again';
           header('Location: login2.php');
         }

     }
   }
}
   ?>
 <!-- <h2 class="text-center"> <?=((isset($_GET['edit']))?'Edit':'');?>Sign up</h2><hr>
 <form class="" action="sign_up.php<?=((isset($_GET['edit']))?'?edit':'?add=1');?>"
  method="post" >
   <div class="form-group col-md-6">
     <label for="name">Full Name:</label>
     <input type="text" name="name" id="name" class="form-control" value="<?=$name;?>">
       </div>

   <div class="form-group col-md-6">
     <label for="email">Email:</label>
     <input type="email" name="email" id="email" class="form-control" value="<?=$email;?>">
       </div>

   <div class="form-group col-md-6">
     <label for="password">Password:</label>
     <input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
       </div>

   <div class="form-group col-md-6">
     <label for="confirm">Confirm Password:</label>
     <input type="password" name="confirm" id="confirm" class="form-control" value="<?=$confirm;?>">
       </div>

   <div onload="permission_signup()"  class="form-group col-md-6">
     <label for="permissions" id="permissions_sign">Permissions:</label>
     <select class="form-control" name="permissions">
       <option value=""<?=(($permissions == '')?' selected':'' );?>></option>
       <option value="editor"<?=(($permissions =='editor')?' selected':'' );?>>Editor</option>
       <option value="admin,editor"<?=(($permissions =='admin, editor')?' selected':'' );?>>Admin</option>
     </select>
       </div>


   <div class="form-group col-md-6 text-right " style="margin-top:25px;">
     <a href="login.php" class="btn btn-default">Login</a>
     <input type="submit"  value="Submit" class="btn btn-primary">
   </div>

   <div class="g-signin2" data-onsuccess="onSignIn"></div>
 </form>
 -->


<?php include 'includes/footer.php';?>
