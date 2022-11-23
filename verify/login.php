<?php include 'controllers/authController.php' ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css" />
  <link rel="stylesheet" href="main.css">
  <title>User verification - Login</title>
</head>
<!-- <style media="screen" href ="">
  body{
    margin:0;
    color:#6a6f8c;
    background:#c8c8c8;
    font:600 16px/18px 'Open Sans',sans-serif;
    background-image:linear-gradient(rgba(0,0,0,0.7),rgba(0,0,0,0.6)), url("../images/headerlogo/background.jpg");
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

</style> -->

<body>
  <div class="container">
    <div class="row">
      <div class="col-md-4 offset-md-4 form-wrapper auth login">
        <h3 class="text-center form-title">Login</h3><hr>
        <form action="login.php" method="post">
          <!-- form title -->
<h3 class="text-center form-title"></h3> <!-- or Login -->

<?php if (count($errors) > 0): ?>
  <div class="alert alert-danger">
    <?php foreach ($errors as $error): ?>
    <li>
      <?php echo $error; ?>
    </li>
    <?php endforeach;?>
  </div>
<?php endif;?>
          <div class="form-group my-3">
            <label>Username or Email:</label>
            <input type="text" name="username" class="form-control form-control-lg" value="<?php echo $username; ?>">
          </div>

          <div class="form-group my-3">
            <label>Password:</label>
            <input type="password" name="password" class="form-control form-control-lg">
          </div>

          <div class="form-group d-grid">
            <button type="submit" name="login-btn" class="my-3 btn btn-block">Login</button>
          </div>
        </form>
        <p>Don't have an account? <a href="sign_up.php">Sign up</a></p>
        <p class="my-3">Go to home page <a href="../index.php">Visit site</a></p>
      </div>
    </div>
  </div>
</body>
</html>
