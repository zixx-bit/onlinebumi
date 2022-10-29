<?php
 require_once $_SERVER['DOCUMENT_ROOT']. '/online store/core/init.php';
 include 'includes/head.php';

 $email = ((isset($_POST['name']))? sanitize($_POST['name']):'');
 $email = trim($email);
 $password = ((isset($_POST['phone']))?sanitize($_POST['phone']):'');
 $password = trim($password);
 $errors = array();
 // $password ='password';
 // $hashed = password_hash($password, PASSWORD_DEFAULT);
 // echo $hashed;
?>
<style media="screen">
  body{

    background-image:linear-gradient(rgba(0,0,0,0.7),rgba(0,0,0,0.6)), url("/online store/images/headerlogo/background.jpg");
    background-size: 100vw 100vh;
    background-attachment: fixed;

  }
</style>

<div id="login-form">
  <div >
    <?php
     if ($_POST) {
        // form validation
      // if (empty($_POST['email']) || empty($_POST['password'])) {
      //   $errors[] = 'You must provide email and password!';
      // }
      //
      // // validate Email
      // if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      //   $errors[] = 'You must enter a valid email!';
      // }
      //
      // if(strlen($password) < 6){
      //   $errors[] = 'Password must be atleast 6 characters!';
      // }
      // check if email exisist in Database
      $query= $db->query("SELECT * FROM transactions WHERE name = '$name' && phone = '$phone'");
      $user = mysqli_fetch_assoc($query);
      //
      // $userCount = mysqli_num_rows($query);
      // if ($userCount < 1) {
      //   $errors [] = 'Wrong email entered!';
      // }
      //
      // // password verify
      // if (!password_verify($password, $user['password'])){
      //   $errors[] = 'The password does not match our records. Please try again!';
      // }
      //
      // if (!empty($errors)) {
      //   echo display_errors($errors);
      // }
      // else {
      //   // login user
      //   $user_id = $user['id'];
      //   login($user_id);
      //
      // }
    }
    ?>
  </div>

  <h2 class="text-center">Login</h2><hr>
  <form class="" action="login.php" method="post">

    <div class="form-group">
      <label for="name">Name:</label>
      <input type="name" name="name" id="name" class="form-control" value="<?=$email;?>">
      </div>

      <div class="form-group">
        <label for="phone">Phone number:</label>
        <input type="phone" name="phone" id ="phone" class="form-control" value="<?=$password;?>">
        </div>

    <div class="form-group">
      <input type="submit" name="" value="Login" class="btn btn-primary">
    </div>
  </form>
  <p class="text-right"> <a href="/online store/index.php" alt="home"> Visit site</a> </p>

</div>

<?php include 'includes/footer.php';?>
