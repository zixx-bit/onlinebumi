 <?php
      require_once 'core/init.php';
      include 'includes/head.php';
      include 'includes/navigation.php';
      include 'includes/headerfull.php';
      // include 'includes/leftsidebar.php';


      //
      // $results_per_page = 10;
      // $number_of_results = mysqli_num_row($featured);
      //
      // $number_of_pages = ceil($number_of_results/$results_per_page);
      //
      // // determining the page number visiitor currently on
      // if (!isset[$_GET['page']]) {
      //   // code...
      //   $page = 1;
      // }else{
      //   $page =$_GET['']
      // }
      $num_per_page = 8;

      if (isset($_GET["page"]))
       {
        // code...
        $page = $_GET["page"];
      }

      else {
        $page=1;
      }

      $start_from = ($page-1)*$num_per_page;
      $sql = $db->prepare("SELECT * FROM products WHERE featured = 1 LIMIT ?,?");
      $sql->bind_param("ii",$start_from, $num_per_page);
      $sql->execute();
      $featured = $sql->get_result();
      // $featured = $sql_fetched->fetch_assoc();
      // $sql= "SELECT * FROM products WHERE featured = 1 LIMIT $start_from, $num_per_page";
      // $featured = $db->query($sql);


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

      <div class="form-group">
        <label for="price">Price:</label> <br>
      <input type="radio" class="  " name="price_sort" value="low" <?=(($price_sort == 'low')?' checked':''); ?>> Low to High <br>
      <input type="radio" class="  " name="price_sort" value="high" <?=(($price_sort == 'high')?' checked':''); ?>> High to Low <br><br>
      <input type="text" name="min_price" class="   price-range form-control col-sm-" placeholder="Min " value="<?=$min_price;?>" style=""> To
      <input type="text" name="max_price" class="   price-range form-control col-sm-" placeholder="Max "value="<?=$max_price;?>"><hr>
    </div>

    <div class=" form-group">
      <label for="brand">Brand:</label>

      <div class="">
      <input type="radio" name="brand" value=""<?=(($b =='')?' checked':'');?>> All <br>
      <?php while ($brand = mysqli_fetch_assoc($brandQ)): ?>
        <input type="radio" name="brand" value="<?=$brand['id'];?>"<?=(($b == $brand['id'])?'checked':'');?>> <?=$brand['brand'];?><br>
      <?php endwhile; ?>
      <br>
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
          <h2 class="text-center">Featured Houses</h2>

        <!-- <h2 class="mb-3 text-primary">Bootstrap 5 Cards Gallery</h2> -->
        </div>
        <?php while ($product = mysqli_fetch_assoc($featured)) :?>

        <div class="col-md-6 col-lg-3 border-0" id="product" >
        <div class="card my-4 py-2  border" style="border-radius:15px;">


            <?php $photos =explode(',', $product['image']); ?>
        <img  id="featured-image" src="<?php echo $photos[0]; ?>" style="width:100%; height:250px; object-fit:cover;"
         class="card-image-top rounded " alt="<?php echo $product['title']; ?>">


        <div class="card-body ">
        <h5 class="card-title  " class="text-secondary lead" > <strong ><?php echo $product['title']; ?></strong></h5>
        <!-- <p class="card-text">HTML stands for Hyper Text Markup Language, It helps to learn web development and designing. </p> -->
        <!-- <a href="#" class="btn btn-primary">Read More</a> -->
        <!-- <p class="list-price text-danger" style="font-size: 13px;">List Price:  <s>Kes <?php echo $product['list_price']; ?></s></p> -->
        <p class="price  " style="font-size: 15px; ">Rent:<span class="text-danger  text-bold" style="font-weight: bold;">  Ksh <?php echo $product ['price']; ?> </span>/month </p>
        <button type="button" class="button-85" onclick="detailsmodal(<?php echo $product['id']; ?>)">Details</button>

        </div>
        </div>
        </div>

        <?php endwhile; ?>

        </div>
        </div>
        </section>




     </div>


<div class="text-center" style="margin-top:50px;">


     <?php

     $sql= "SELECT * FROM products WHERE featured = 1 ";

     $featured = $db->query($sql);



      $total_records = mysqli_num_rows($featured);
      $total_pages = ceil($total_records/$num_per_page);

      // echo $total_records;

     // echo $total_pages;

     if ($page>1) {
       echo "<a href='index.php?page=".($page-1)."' class='btn btn-sm btn-info' style='margin-right:5px;'> << Previous</a>";
     }

      for ($i=1; $i<$total_pages; $i++ ) {
        // echo "<a href='index.php?page=".$i."' class='btn btn-success'>".$i."</a>";
        if ($page==$i) {
          echo  "<a href='index.php?page=".$i."' class='btn btn-sm btn-warning'>".$i."</a>"; ;
        }
         else {
          echo "<a href='index.php?page=".$i."' class='btn btn-sm btn-default' style='margin:2px;'>".$i."</a>";
        }

      }

      if ($i>$page) {
        echo "<a href='index.php?page=".($page+1)."' class='btn btn-sm btn-info' style='margin-left:5px;'>Next >></a>";
      }

  ?>
  </div>
   </div>





<?php
  // include 'includes/detailsmodal.php';
  // include 'includes/rightsidebar.php';
  include 'includes/footer.php';
  // include 'includes/footer1.php';
 ?>
