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
  <br>
  <input type="submit" name="" value="Search" class="btn btn-primary"></div>
  </div>

</form>
</div>
