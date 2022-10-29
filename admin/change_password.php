<?php

 require_once $_SERVER['DOCUMENT_ROOT']. '/core/init.php';
if (!is_logged_in()) {
  login_error_redirect();
}
 include 'includes/head.php';
 $hashed = $user_data['password'];
 $old_password = ((isset($_POST['old_password']))?sanitize($_POST['old_password']):'');
 $old_password = trim($old_password);
 $password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
 $password = trim($password);
 $confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
 $confirm = trim($confirm);
 $new_hashed = password_hash($password, PASSWORD_DEFAULT);
 $user_id = $user_data['id'];
 $errors = array();
 $messages = array();
 // $password ='password';
 // $hashed = password_hash($password, PASSWORD_DEFAULT);
 // echo $hashed;
?>
<style media="screen">
  body{
    background-image: url("/neokenya/images/4.jpg");
    background-size: 100vw 100vh;
    background-attachment: fixed;
  }
</style>

<div id="login-form">
  <div >
    <?php
     if ($_POST) {
        // form validation
      if (empty($_POST['old_password']) || empty($_POST['password']) || empty($_POST['confirm'])) {
        $errors[] = 'You must fill out all fields!';
      }

      if(strlen($password) < 6 && !empty($_POST['password'])) {
        $errors[] = 'Password must be atleast 6 characters!';
      }
       // check if new password matches confirm
       if ($password != $confirm ) {
         $errors[] = 'The new password does not match confirm new password!';
       }
      // password verify
      if (!empty($_POST['old_password']) && !password_verify($old_password, $hashed)) {
        $errors[] = 'Your old password does not match our records. Please try again!';
      }

      if (!empty($errors)) {
        echo display_errors($errors);
      }
      else {
        // change password
      $change_pass = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
      $change_pass->bind_param("si", $new_hashed, $user_id);
      $change_pass->execute();

      $messages[] = 'Your password has been changed';
      echo successMessage($messages);
        // $_SESSION['success_flash'] = 'Your password has been changed!';
        header('Location: index.php');


      }
    }
    ?>
  </div>

  <h2 class="text-center">Change Password</h2><hr>
  <form class="" action="change_password.php" method="post">

    <div class="form-group">
      <label for="old_password">Old Password:</label>
      <input type="password" name="old_password" id="old_password" class="form-control" value="<?=$old_password;?>">
      </div>

      <div class="form-group">
        <label for="password">New Password:</label>
        <input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
        </div>

        <div class="form-group">
          <label for="confirm">Cornfirm New Password:</label>
          <input type="password" name="confirm" id="confrim" class="form-control" value="<?=$confirm;?>">
          </div>


    <div class="form-group">
      <a href="index.php" class="btn btn-default">Cancel</a>
      <input type="submit" name="" value="Login" class="btn btn-primary">
    </div>
  </form>
  <p class="text-right"> <a href="bumihouse.site/index.php" alt="home"> Visit site</a> </p>

</div>

<?php include 'includes/footer.php';?>
