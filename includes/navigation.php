
<?php
$sql = "SELECT * FROM categories WHERE parent =0";
$pquery = $db->query($sql);
 ?>

 <nav id="navbar_top" class="navbar navbar-expand-lg navbar-dark py-3"
    style="
      /* background-image: linear-gradient(#0dccea, #0d70ea); color:#fff; */
        background-image: linear-gradient(144deg, #AF40FF, #5B42F3 50%,#00DDEB);
      ">
    <div class="container">
    	 <a class="navbar-brand" href="index.php">Bumi House</a>
       <button class="btn btn-sm btn-info" type="button"
        data-bs-toggle="offcanvas"
        data-bs-target="#offcanvasWithBothOptions"
        aria-controls="offcanvasWithBothOptions">Search by</button>
     <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main_nav">
         <span class="navbar-toggler-icon"></span>
       </button>
     <div class="collapse navbar-collapse" id="main_nav">


            <ul class="navbar-nav ms-auto" >

            <li><a class="btn-sm button-86" href="admin/products.php?add"
              style=" background-image: linear-gradient(to bottom right, #fcd34d, #ef4444, #ec4899);"> Submit Property+ </a></li> <br>
            <li><a class="btn-sm button-70" href="admin/"><span class="glyphicon glyphicon-log-out"></span> sign Up </a></li> <br>
            <li><a class=" button-70" href="admin/login.php"> <span class="glyphicon glyphicon-log-in"> </span>  Login</a></li>
           	</ul>

     </div> <!-- navbar-collapse.// -->
    </div> <!-- container-fluid.// -->
   </nav>

<!--Top Navbar-->


<?php
$sql = "SELECT * FROM categories WHERE parent =0";
$pquery = $db->query($sql);

 ?>

   <nav id="nav" class="nav " style="">
      <div id="nav__outer-wrap" class="nav__outer-wrap">
        <div id="nav__heading" class="nav__heading">
        </div>
        <ul id="nav__inner-wrap" class="nav__inner-wrap">
          <?php while ($parent = mysqli_fetch_assoc($pquery)) : ?>
            <?php
              $parent_id = $parent['id'];
              $sql2 = "SELECT * FROM categories where parent = '$parent_id'";
              $cquery = $db->query($sql2);
              // var_dump($cquery);
             ?>
          <li id="nav__item--178" class="nav__item nav__menu-item nav__menu-item--has-children"
           tabindex="0">

                <span class="nav__link nav__link--has-dropdown" style="overflow:auto;">
                  <?php echo $parent['category']; ?>
              <svg class="icon icon--dropdown" viewBox="0 0 24 24" style="height: 1em; width: 1em">
                <path d="M16.594 8.578l1.406 1.406-6 6-6-6 1.406-1.406 4.594 4.594z"></path>
              </svg>
            </span>
            <ul class="nav__dropdown " >
              <?php while ($child = mysqli_fetch_assoc($cquery)): ?>

              <li class="nav__menu-item nav__item--repeated">

                <a class="nav__link" href="category.php?cat=<?php echo $child['id']; ?>">
                  <?php echo $child['category']; ?>
                </a>
              </li>
            <?php endwhile; ?>
            </ul>
          <?php endwhile; ?>
          <!-- <li id="nav__item--right-spacer" class="nav__item nav__item--right-spacer"></li> -->
        </ul>
      </div>
      <button id="nav__scroll--left" class="nav__scroll nav__scroll--left hide">‹</button>
      <button id="nav__scroll--right" class="nav__scroll nav__scroll--right hide">›</button>
    </nav>
