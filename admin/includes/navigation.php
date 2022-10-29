<!--Top Navbar-->
<nav class="navbar navbar-default navbar-fixed-top " role="navigation">
  <div class="container">
 <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#topNav">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    <a href="index.php" class="navbar-brand"> Dashboard</a>
    </div>
    <div class="collapse navbar-collapse"id="topNav">
    <ul class="nav navbar-nav ">
      <!-- order -->
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle = "dropdown">Orders
          <span class="caret"></span>
        </a>
        <ul class="dropdown-menu" role="menu">
          <li> <a href="index.php"> orders made</a> </li>
          <li>  <a href="shipped.php">Shipped orders</a> </li>
        </ul>
      </li>
   <!-- menu items -->
   <?php if (has_permission('admin')): ?>
   <li> <a href="mpesa_payments.php">Payments</a> </li>
 <?php endif; ?>
   <li> <a href="brands.php">House Type</a> </li>
      <li> <a href="categories.php">Location</a> </li>

      <li> <a href="products.php">Houses</a> </li>
      <?php if(has_permission('admin')):?>

      <li> <a href="archived.php">Archived</a> </li>
      <li> <a href="inventory.php">Inventory</a> </li>
      <li> <a href="customers.php">Customers</a> </li>
    <?php endif;?>
      <?php if(has_permission('admin')):?>
      <li> <a href="users.php">Users</a> </li>
    <?php endif; ?>
    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle = "dropdown">Hello <?=$user_data['first'];?> :)
        <span class="caret"></span>
      </a>
      <ul class="dropdown-menu" role="menu">
        <li> <a href="change_password.php">Change Password</a> </li>
        <li>  <a href="logout.php">Log Out</a> </li>
      </ul>
      <li> <a href="logout.php"> <span class="glyphicon glyphicon-log-out"></span> Log Out</a> </li>

    </li>

      <li class="dropdown">
        <ul class="dropdown-menu" role="menu">
          <li><a href="#"></a></li>
        </ul>
      </li>
    </ul>
  </div>
  </div>
</nav>
