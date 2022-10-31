<?php
// error_reporting(1);
 require_once $_SERVER['DOCUMENT_ROOT']. '/online store/core/init.php';
 // include 'includes/head.php';
 $name ="";
 $email ="";
 $password ="";
 $confirm ="";
 $permissions = "";

      if (isset($_GET['signIn-btn'])) {
          $email = ((isset($_POST['email']))? sanitize($_POST['email']):'');
          $email = trim($email);
          $password = ((isset($_POST['password']))? sanitize($_POST['password']):'');
          $password = trim($password);
          $errors = array();
          $messages = array();

                // form validation
              if (empty($_POST['email']) || empty($_POST['password'])) {
                $errors[] = 'You must provide email and password!';
              }

              // validate Email
              if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'You must enter a valid email!';
              }

              if(strlen($password) < 6){
                $errors[] = 'Password must be atleast 6 characters!';
              }
              // check if email exisist in Database
              $query = $db->prepare("SELECT * FROM users WHERE email =? ");
              $query->bind_param("s", $email);
              $query->execute();
              $query_fetched = $query->get_result();
              $user = $query_fetched->fetch_assoc();
              $userCount = mysqli_num_rows($query_fetched);
              if ($userCount < 1) {
                $errors [] = 'Wrong credentials';
              }

              // password verify
              if (!password_verify($password, $user['password'])){
                $errors[] = '';
              }
                 if (!empty($errors)) {
                   display_errors($errors);
                } else {
                // login user
                $user_id = $user['id'];
                login($user_id);

              }
            }

    // sign up
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

                if ($emailCount != 0) {
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
                   display_errors($errors);
                } else {
                  // add user to databse
                  $hashed = password_hash($password, PASSWORD_DEFAULT);
                  $add_user = $db->prepare("INSERT INTO users (full_name,email,password,permissions)
                  Values (?, ?, ?, ?)");
                    $add_user->bind_param("ssss", $name, $email, $hashed, $permissions);
                    $add_user->execute();
                    if ($add_user->execute() == true) {
                      $_SESSION['success_flash'] = ' Sign up succesfull. Try  to login in';
                      header('Location: login.php');
                    }else {
                      $_SESSION['error_flash'] = ' Sign up failed! Try again';
                      header('Location: login.php');
                    }
                }
              }
            }

                // #delete duplicates
                // $duplicate = $db->prepare("SELECT * FROM users WHERE email = '?'");
                // $dubplicate->bind_param("s",$email);
                // $duplicate->execute();
                // $duplicate_result = $duplicate->get_result();
                // $check->mysqli_num_rows($duplicate_result);
                //
                // if ($check>0) {
                //   // delete duplicate
                //   $deleteDup = $db->query("DELETE FROM users WHERE email = '$email'");



  ?>


    <!DOCTYPE html >
    <html>
    <head>
     <title>
      login
     </title>
     <!-- <link rel="stylesheet" href="../css/bootstrap.min.css"> -->
     <link rel="stylesheet" href="../css/main.css">
     <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Open+Sans:600'>

     <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
     <meta name="google-signin-client_id" content="YOUR_CLIENT_ID.apps.googleusercontent.com">
     <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> -->
     <!-- <script src="../js/bootstrap.min.js"></script> -->
    </head>

      <!-- <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Open+Sans:600'> -->
          <!-- <link rel="stylesheet" href="app/assets/css/style.css"> -->
          <style media="screen" href ="">
            body{
              margin:0;
              color:#6a6f8c;
              background:#c8c8c8;
              font:600 16px/18px 'Open Sans',sans-serif;
              background-image:linear-gradient(rgba(0,0,0,0.7),rgba(0,0,0,0.6)), url("/images/headerlogo/background.jpg");
              background-size: 100vw 100vh;
              background-attachment: fixed;

            }
              *,:after,:before{box-sizing:border-box}
              .clearfix:after,.clearfix:before{content:'';display:table}
              .clearfix:after{clear:both;display:block}
              a{color:inherit;text-decoration:none}
              .login-wrap{
                width:100%;
                margin:auto;
                margin-top: 30px;
                max-width:525px;
                min-height:670px;
                position:relative;
                background:url(http://codinginfinite.com/demo/images/bg.jpg) no-repeat center;
                box-shadow:0 12px 15px 0 rgba(0,0,0,.24),0 17px 50px 0 rgba(0,0,0,.19);
              }

          </style>

<!-- sign up -->
<div class="text-danger" style=" color:#CC0000; font-weight:100;">
  <?php
         if (!empty($errors)) {
          echo display_errors($errors);
          }
   ?>

</div>

<div class="" style="">


</div>

    <div class=""  >
      <div class="login-wrap">
        <div class="login-html">
        <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Log In</label>
        <input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">Register</label>
        <div class="login-form">
            <form class="sign-in-htm"  method="post" autocomplete="on">
            <div class="group">
              <label for="user" class="label">Email:</label>
              <input type="email" name="email" id="email" type="email"class="input"  data-type="email" value="<?php echo $email; ?>" >
              </div>

            <div class="group">
              <label for="password" class="label">Password:</label>
              <input id ="password" type="password" name="password"   class="input" value="<?=$password;?>">
            </div> <br>

            <!-- <div class="group">
              <input id="check" type="checkbox" class="check" checked>
              <label for="check"><span class="icon"></span> Keep me Signed in</label>
            </div> -->

            <div class="group">
              <input type="submit" class="button" name="signIn-btn" value="Log In">
            </div>
            <div class="g-signin2" data-onsuccess="onSignIn"></div>

            <div class="hr"></div>
            <div class="foot-lnk">
              <p>Don't have an account?
                       <input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">Register</label>
                      </p>
                <a href="/index.php">Visit site</a>
            </div>
            <div class="foot-lnk pull-right">

            </div>

          </form>

          <form class="sign-up-htm"  method="post" autocomplete="on">
            <div class="group">
              <label for="user" class="label">Full Name:</label>
              <input id="name" name="name" type="text" value="<?php
              echo $name;?>" class="input">
            </div>
            <div class="group">
              <label for="pass" class="label">Email:</label>
              <input id="email" name="email" type="email"
              value="<?php echo $email;?>" class="input" data-type="email">
            </div>
            <div class="group">
              <label for="pass" class="label">Password:</label>
              <input id="password" name="password" type="password"
              value="<?php echo $password;?>" class="input" data-type="password">
            </div>
            <div   class="form-group col-md-6" style="">
              <label for="permissions" id="permissions_sign">Permissions:</label>
              <select class="form-control" name="permissions">
                <!-- <option value=""<?=(($permissions == '')?' selected':'' );?>></option> -->
                <option value="editor"<?=(($permissions =='editor')?' selected':'' );?>>Editor</option>
                <!-- <option value="admin,editor"<?=(($permissions =='admin, editor')?' selected':'' );?>>Admin</option> -->
              </select>
                </div>
            <div class="group">
              <label for="pass" class="label">Confirm Password:</label>
              <input id="pass" type="password" name="confirm" class="input"
               value="<?php  echo $confirm;?>" data-type="password">
            </div>
            <div class="group">
              <input type="submit" name="signUp-btn" class="button" value="Register">
            </div>

            <div class="group">
              <p class="text-center">OR</p>
            </div>

            <div class="group">
              <div class=" flex g-signin2 "  style="border-radius:5px;" data-onsuccess="onSignIn"></div>

            </div>

            <div class="hr"></div>
            <div class="foot-lnk">
              <!-- <div class="g-signin2 tab-1" data-onsuccess="onSignIn"></div> -->

              <!-- <label for="tab-1">Already Member?</a> -->
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <?php include "includes/footer.php"; ?>
