<!-- Header-->
<!-- <div id="headerWrapper">
 <div id="back-flower"></div>
<div id="logotext"><h1>MICHIRA</h1></div>
<div id="fore-flower"></div> -->

<?php


 require_once 'core/init.php';

?>
<div class="page-wrapper" style="background-color:;" >


<div class="posts-slider">
  <h1 class="slider-title"></h1>
  <i class="fa fa-chevron-right next"></i>
  <i class="fa fa-chevron-left prev"></i>
  <div class="posts-wrapper">
    <?php
      $sql = "SELECT * FROM products WHERE featured = 1";
      $featured = $db->query($sql);
    ?>
    <?php while ($product = mysqli_fetch_assoc($featured)) :?>
      <!-- // var_dump($product);?> -->
<!-- search -->


    <div class="post" >
      <div class="inner-post card border-0  " id="headerfull_post" style="height:auto; width:185px;">
        <?php $photos = explode(',',$product['image']); ?>
        <img class="card-image-top rounded "
          style="height:170px; width:150px; object-fit:cover; "
        src="<?php echo $photos[0];?>" alt=" <?php echo $product['title']; ?>">

        <div class="card-body ">
        <h5 class="card-title  " class="text-secondary lead" > <strong ><?php echo $product['title']; ?></strong></h5>
        <!-- <p class="card-text">HTML stands for Hyper Text Markup Language, It helps to learn web development and designing. </p> -->
        <!-- <a href="#" class="btn btn-primary">Read More</a> -->
        <!-- <p class="list-price text-danger" style="font-size: 13px;">List Price:  <s>Kes <?php echo $product['list_price']; ?></s></p> -->
        <!-- <p class="price  " style="font-size: 15px; ">/month </p> -->
        <button type="button" class="button-85" onclick="detailsmodal(<?php echo $product['id']; ?>)">
          Rent:<span class=" " style="">  Ksh  <?php echo $product['price']; ?> </span>  </button>

        </div>
        <!-- <div class="post-info">
          <h4 style="margin-left:auto;"  ><?php echo $product['title'];  ?></h4>
          <h5 class="button-70" onclick="detailsmodal(<?php echo $product['id']; ?>)"
             style="margin-left:auto;">Rent: Ksh <?php echo $product['price'];?> </h5>

        </div> -->
      </div>
    </div>
  <?php endwhile; ?>
</div>
</div>
</div>
