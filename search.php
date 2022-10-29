<?php
      require_once 'core/init.php';
      include 'includes/head.php';
      include 'includes/navigation.php';
      include 'includes/headerpartial.php';
      // include 'includes/leftsidebar.php';

      // $id = $_POST['id'];
      // $cat2_id = (int)$id;
      //
      $sql = "SELECT * FROM products ";
      // if ($cat2_id == '') {
      //    $sql .= " WHERE deleted = 0 ";
      //  }else {
      //    $sql .= " WHERE id = '$cat2_id' AND deleted = 0 ";
      //  }

      // cat id
      $cat_id = (($_POST['cat'] != '')? sanitize($_POST['cat']):'');
      if ($cat_id == '') {
         $sql .= " WHERE deleted = 0 ";
       }else {
         $sql .= " WHERE categories  '{$cat_id}' AND deleted = 0 ";
       }
       //
       // $cat2_id = (($_POST['id'] != '')? sanitize($_POST['id']):'');
       // if ($cat2_id == '') {
       //    $sql .= " WHERE deleted = 0 ";
       //  }else {
       //    $sql .= " WHERE id = '{$cat2_id}' AND deleted = 0 ";
       //  }


       $price_sort = (($_POST['price_sort'] !='')? sanitize($_POST['price_sort']):'');
       $min_price = (($_POST['min_price'] != '')? sanitize($_POST['min_price']):'');
       $max_price = (($_POST['max_price'] != '')? sanitize($_POST['max_price']):'');
       $brand = (($_POST['brand'] != '')? sanitize($_POST['brand']):'');
       $name = (($_POST['name'] != '')? sanitize($_POST['name']):'');

      if ($name != '') {
        $sql .= " AND title LIKE '%" .$name. "%' ";
      }else{
         $sql .= " ";
      }
       if ($min_price != '') {
         $sql .= " AND price >= '{$min_price}'";
       }else {
         // code...
         $sql .= " ";
       }

       if ($max_price != '') {
         $sql .= " AND price <= '{$max_price}'";
       }
       else{
          $sql .= " ";
       }
       if ($brand != '') {
         $sql .= " AND brand = '{$brand}'";
       }else{
          $sql .= " ";
       }

       if ($price_sort == 'low') {
         $sql .= " ORDER BY price";
       }else{
          $sql .= " ";
       }
       if ($price_sort == 'high') {
         $sql .= " ORDER BY price DESC";
       }else{
          $sql .= " ";
       }

      $productQ = $db->query($sql);
      // var_dump($sql);
      $category = get_category($cat_id);
      // $category = get_category($search_id);

      // var_dump($cat_id);
 ?>
 <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">Backdroped with scrolling</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <?php

     $cat_id = ((isset($_REQUEST['cat']))?sanitize($_REQUEST['cat']):'');
     $price_sort = ((isset($_REQUEST['price_sort']))? sanitize($_REQUEST['price_sort']):'');
     $min_price = ((isset($_REQUEST['min_price']))? sanitize($_REQUEST['min_price']):'');
     $max_price = ((isset($_REQUEST['max_price']))? sanitize($_REQUEST['max_price']):'');
     $name = ((isset($_REQUEST['name']))? sanitize($_REQUEST['name']):'');

    $b = ((isset($_REQUEST['brand']))?sanitize($_REQUEST['brand']):'');
    $brandQ= $db->query("SELECT * FROM brand ORDER BY brand");

     ?>
     <div class="scaled" id="search-price">


    <h3 class="">Search By:</h3>

    <form class=""  action="search.php" method="post">
      <div class="form-group">
        <label for="Search">Name:</label>
        <input type="text" name="name" id="" placeholder="Search" class="form-control" value="<?=$name;?>">



        </div>


        <hr>

      <input type="hidden" name="cat" value="<?=$cat_id?>">
      <?php
      // var_dump($cat_id);
       ?>
      <input type="hidden" name="price_sort" value="0">

      <div class="   form-group">
        <label for="price">Price:</label> <br>
      <input type="radio" class="  " name="price_sort" value="low" <?=(($price_sort == 'low')?' checked':''); ?>> Low to High <br>
      <input type="radio" class="  " name="price_sort" value="high" <?=(($price_sort == 'high')?' checked':''); ?>> High to Low <br><br>
      <input type="text" name="min_price" class="   price-range form-control col-xs-" placeholder="Min " value="<?=$min_price;?>" style=""> To
      <input type="text" name="max_price" class="   price-range form-control col-xs-" placeholder="Max "value="<?=$max_price;?>"><hr>
    </div>

    <div class="   form-group">
      <label for="brand">Brand:</label>

      <div class="">
      <input type="radio" name="brand" value=""<?=(($b =='')?' checked':'');?>> All <br>
      <?php while ($brand = mysqli_fetch_assoc($brandQ)): ?>
        <input type="radio" name="brand" value="<?=$brand['id'];?>"<?=(($b == $brand['id'])?'checked':'');?>> <?=$brand['brand'];?><br>
      <?php endwhile; ?>

      <input type="submit" name="" value="Search" class="btn btn-primary"></div>
      <br> <br>
      </div>

    </form>
    </div>


  </div>
</div>




 <section class="bg-light py-4 my-5">

         <div class="container">
         <div class="row">
         <div class="col-md-12">
           <h2 class="text-center">productQ Houses</h2>

         <!-- <h2 class="mb-3 text-primary">Bootstrap 5 Cards Gallery</h2> -->
         </div>
         <?php while ($product = mysqli_fetch_assoc($productQ)) :?>

         <div class="col-md-6 col-lg-3 border-0" id="product" style="">
         <div class="card my-4  border">


             <?php $photos =explode(',', $product['image']); ?>
         <img src="<?php echo $photos[0]; ?>" style="width:100%; height:250px; object-fit:cover;"
          class="card-image-top rounded " alt="<?php echo $product['title']; ?>">


         <div class="card-body ">
         <h5 class="card-title  " class="text-secondary"> <?php echo $product['title']; ?></h5>
         <!-- <p class="card-text">HTML stands for Hyper Text Markup Language, It helps to learn web development and designing. </p> -->
         <!-- <a href="#" class="btn btn-primary">Read More</a> -->
         <!-- <p class="list-price text-danger" style="font-size: 13px;">List Price:  <s>Kes <?php echo $product['list_price']; ?></s></p> -->
         <p class="price  " style="font-size: 15px; ">Rent:<span class="text-primary lead text-bold" style="font-weight: bold;">  Ksh <?php echo $product ['price']; ?></span> </p>
         <button type="button" class="button-85" onclick="detailsmodal(<?php echo $product['id']; ?>)">Details</button>

         </div>
         </div>
         </div>

         <?php endwhile; ?>

         </div>
         </div>
         </section>





<?php
  // include 'includes/detailsmodal.php';
  // include 'includes/rightsidebar.php';
  include 'includes/footer.php';
 ?>
