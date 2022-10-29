<?php
      require_once 'core/init.php';
      include 'includes/head.php';
      include 'includes/navigation.php';
      include 'includes/headerpartial.php';
      include 'includes/leftsidebar.php';

     //  $sql = '';
     //  if(isset($_GET["id"])) {
     // $search_id = $_GET["id"];
     // $search_id = (int)$search_id;
     //
     //   }
     $search_id = base64_decode($_GET['id']);

       $sql = "SELECT * FROM products WHERE id = '$search_id' AND deleted = 0  ";
       $productQ = $db->query($sql);


       // var_dump($sql);


 ?>

     <!-- main body -->
     <div class="col-md-8">
       <div class="row">
         <h2 class="text-center"> Online Shop</h2>


        <?php

         while ($product = mysqli_fetch_assoc($productQ)) :
           ?>
         <div class="col-sm-3 offset-sm-2 col-md-6 offset-md-0 text-center"
         style="margin-top: 20px; display: block;
  margin-left: auto;
  margin-right: auto;
  " id="product">
           <h4 ><?php echo $product['title']; ?></h4>
           
           <div class="img-thumb" style="margin-bottom:15px;">
                  <?php $photos = explode(',', $product['image']); ?>
                  <img   src="<?php echo $photos[0]; ?>" id="img-thumb" alt="<?php echo $product['title']; ?>" >
           </div>

           <p class="list-price text-danger">List Price:<s>Kes <?php echo $product['list_price']; ?></s></p>
           <p class="price">Our Price: Kes <?php echo $product ['price']; ?></p>
           <button type="button" class="btn btn-sm btn-success" onclick="detailsmodal(<?php echo $product['id']; ?>)">Details</button>
         </div>
       <?php endwhile; ?>

     </div>
   </div>


<?php
  // include 'includes/detailsmodal.php';
  include 'includes/rightsidebar.php';
  include 'includes/footer.php';
 ?>
