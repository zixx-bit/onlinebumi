<?php
error_reporting(0);
?>

<!--Top Navbar-->
<nav class="  navbar navbar-default navbar" role="navigation">
 <div class="container">
   <div class="navbar-header">
     <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#topNav">
       <span class="icon-bar"></span>
       <span class="icon-bar"></span>
       <span class="icon-bar"></span>
     </button>



     <?php

       if ($cart_id != '') {
       $cartQ = $db->query("SELECT  * FROM cart where id = '{$cart_id}'");
       $result = mysqli_fetch_assoc($cartQ);
       $items = json_decode($result['items'], true);


       $i = 1;
       $item_count = 0;
     }

        foreach ($items as $item) {   // code...


        $i++;
        $item_count += $item['quantity'];

        if ($item_count == 0) {

        }

        }

      ?>


     <a class="navbar-brand" href="index.php">Online Shop</a>

      <!-- cart emoticon -->

     </div>


   <div class=" col-md-8 collapse navbar-collapse" id="topNav">
     <ul class="nav navbar-nav ">
       <?php

       $sql = "SELECT CONCAT( REPEAT(' ', COUNT(parent.location) - 1), node.location) AS location
        FROM locations AS node,
        locations AS parent
        WHERE node.lft BETWEEN parent.lft AND parent.rgt AND parent.lft >1
        GROUP BY node.lft
        ORDER BY node.lft";



        // $sql = " SELECT p.*  FROM locations n , locations p
	      //  WHERE n.lft BETWEEN p.lft AND p.rgt AND p.lft > 1
        //  GROUP BY n.lft
        //   ORDER BY n.lft;";
         $pquery = $db->query($sql);



       while($parent = mysqli_fetch_assoc($pquery)):
         ?>

         <?php
          // $parent_id = $parent['id'];
          // $sql2 = "SELECT * FROM categories WHERE parent = '$parent_id'";
          // $cquery = $db->query($sql2);
          ?>
       <!-- <li class="active"> <a href="#">Home</a> </li> -->
       <li class="dropdown">
       <a id="dropdown" href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $parent['location']; ?><span class="caret"></span></a>
       <ul class="dropdown-menu" role="menu">
         <?php while ($child = mysqli_fetch_assoc($pquery)): ?>
         <li ><a href="category.php?cat=<?=$child['id'];?>"><?php echo $child ['location']; ?></a></li>
       <?php endwhile; ?>
       </ul>
       </li>
     <?php
    endwhile;
    ?>
     <!-- <div class="bg-warning"> -->



     <!-- <span class="pull-right"> <a href="admin/index.php "> <span class="glyphicon glyphicon-log-in"></span> Admin </a> </span> -->

       </ul>

     </div>

                   <span  id="nav-cart" class="" ><a href="cart.php " class=""> <span  class="glyphicon glyphicon-shopping-cart">
                   </span> <span style=""></span> </a>
                   <span id="loading2">
                   <span id="nav-cart-span" class="">
                     <span style="color: #eb8e02;">
                      <?=$item_count;?>
                      </span>
                   </span>
                   </span>
                 </span>


                   <span class="pull-right" style="margin-top:20px; font-size:14px;"> <a href="admin/index.php ">
                      <span class="glyphicon glyphicon-log-in"></span>&nbsp Admin Login</a> </span>



     </div>



     <!-- live search -->
     <div class="text-center" width="50%">
        <?php
        require BASEURL.'live_search.php';

       // include "/live_search.php";
       ?>
   </div>
</nav>
