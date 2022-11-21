 <?php
require_once $_SERVER['DOCUMENT_ROOT']. '/core/init.php';
if (!is_logged_in()) {
  login_error_redirect();
}
// require_once BASEURL.'admin/includes/head.php';
// require_once BASEURL.'admin/includes/navigation.php';

include 'includes/head.php';
include 'includes/navigation.php';
$dbpath='';

if (isset($_GET['delete'])) {
 $del_id = sanitize($_GET['delete']);
  $deleteQ = $db->prepare("UPDATE products SET deleted = ? WHERE id = ?");
    $del_= 1;
  $deleteQ->bind_param("ii",$del_, $del_id);
  $deleteQ->execute();

header('Location:products.php');
}

// user inserts and select
// $emailQuery = $db->prepare("SELECT * FROM users WHERE email = ? ");
// $emailQuery->bind_param("s", $email);
// $emailQuery->execute();
// $emailQ_fetched = $emailQuery->get_result();
// $emailCount = mysqli_num_rows($emailQ_fetched);



// if statement clears product page
if(isset($_GET['add']) || isset($_GET['edit'])) {
  $brandQuery = $db->query("SELECT * FROM brand  ORDER BY brand");
   $parentQuery = $db->query("SELECT * FROM categories WHERE parent = 0  ORDER BY category");
    // $parent = 0;
   // $parentQuery->bind_param("i", $parent);
   // $parentQuery->execute();
   $title=((isset($_POST['title']) && $_POST['title'] != '')? sanitize($_POST['title']):'');
   $brand = ((isset($_POST['brand']) && !empty($_POST['brand']))? sanitize($_POST['brand']):'');
   $parent = ((isset($_POST['parent']) && !empty($_POST['parent']))? sanitize($_POST['parent']):'');
   $category = ((isset($_POST['child']) && !empty($_POST['child']))? sanitize($_POST['child']):'');
   $price = ((isset($_POST['price']) && !empty($_POST['price']))? sanitize($_POST['price']):'');
   $list_price = ((isset($_POST['list_price']) && !empty($_POST['list_price']))? sanitize($_POST['list_price']):'');
   $description= ((isset($_POST['description']) && !empty($_POST['description']))? sanitize($_POST['description']):'');
   $sizes= ((isset($_POST['sizes']) && !empty($_POST['sizes']))? sanitize($_POST['sizes']):'');

   $sizes = rtrim($sizes, ',');
  $saved_image = '';
  $latitude= ((isset($_POST['latitude']) && !empty($_POST['latitude']))? sanitize($_POST['latitude']):'');
  $longitude= ((isset($_POST['longitude']) && !empty($_POST['longitude']))? sanitize($_POST['longitude']):'');

   // edit function
   if(isset($_GET['edit'])){
        // if edit icon is clicked

        if (has_permission('admin')) {

        $user = $user_data['email'];
        $edit_id = (int)$_GET['edit'];
        $product_results = $db->prepare("SELECT * FROM products WHERE id = ? ");
        $product_results->bind_param("i", $edit_id, );
        $product_results->execute();
        $product_fetched = $product_results->get_result();
        $product= $product_fetched->fetch_assoc();

  // edit product image
        if(isset($_GET['delete_image'])) {
          $imgIncr = (int)$_GET['imgIncr'] - 1;
          $images = explode(',',$product['image']);
          $image_url = $_SERVER['DOCUMENT_ROOT'].$images[$imgIncr];
          unlink($image_url);
          unset($images[$imgIncr]);
          $imageString = implode(',', $images);
          $delete__image = $db->prepare("UPDATE products SET image = ? WHERE id = ? ");
          $delete__image->bind_param("si", $imageString, $edit_id );
          $delete__image->execute();

          header('Location: products.php?edit='.$edit_id);
        }

        $category = ((isset($_POST['child']) && $_POST['child']) != '')? sanitize($_POST['child']):$product['categories'];
        $title=((isset($_POST['title']) && $_POST['title'] != '')? sanitize($_POST['title']):$product['title']);
        $brand=((isset($_POST['brand']) && $_POST['brand'] != '')? sanitize($_POST['brand']):$product['brand']);
        $parentQ = $db->prepare("SELECT * FROM categories WHERE id =?");
        $parentQ->bind_param("s", $category);
        $parentQ->execute();
        $parent_fetched = $parentQ->get_result();
        $parent_results = $parent_fetched->fetch_assoc();


        $parent= ((isset($_POST['parent']) && $_POST['parent'] != '')? sanitize($_POST['parent']):$parent_results['parent']);
        $title=((isset($_POST['title']) && $_POST['title'] != '')? sanitize($_POST['title']):$product['title']);
        $price=((isset($_POST['price']) && $_POST['price'] != '')? sanitize($_POST['price']):$product['price']);
        $list_price=((isset($_POST['list_price']) )? sanitize($_POST['list_price']):$product['list_price']);
        $description=((isset($_POST['description']))? sanitize($_POST['description']):$product['description']);
        $sizes=((isset($_POST['sizes']) && $_POST['sizes'] != '')? sanitize($_POST['sizes']):$product['sizes']);
        $sizes = rtrim($sizes,',');
        $saved_image =(($product['image'] != '')?$product['image']:'');
        $dbpath=$saved_image;
        $latitude= ((isset($_POST['latitude']) && !empty($_POST['latitude']))? sanitize($_POST['latitude']):'');
        $longitude= ((isset($_POST['longitude']) && !empty($_POST['longitude']))? sanitize($_POST['longitude']):'');

     } else {
     // code...
         $user = $user_data['email'];
         $edit_id = (int)$_GET['edit'];
         $product_results = $db->prepare("SELECT * FROM products WHERE id = ? AND user =? ");
         $product_results->bind_param("is", $edit_id, $user);
         $product_results->execute();
         $product_fetched = $product_results->get_result();
         $product= $product_fetched->fetch_assoc();
         // echo var_dump($product);

      // edit product image
         if(isset($_GET['delete_image'])) {
           $imgIncr = (int)$_GET['imgIncr'] - 1;
           $images = explode(',',$product['image']);
           $image_url = $_SERVER['DOCUMENT_ROOT'].$images[$imgIncr];
           unlink($image_url);
           unset($images[$imgIncr]);
           $imageString = implode(',',$images);
           $delete__image = $db->prepare("UPDATE products SET image = ? WHERE id = ? ");
           $delete__image->bind_param("si", $imageString, $edit_id );
           $delete__image->execute();

           header('Location: products.php?edit='.$edit_id);
         }

         $category = ((isset($_POST['child']) && $_POST['child']) != '')? sanitize($_POST['child']):$product['categories'];
         $title=((isset($_POST['title']) && $_POST['title'] != '')? sanitize($_POST['title']):$product['title']);
         $brand=((isset($_POST['brand']) && $_POST['brand'] != '')? sanitize($_POST['brand']):$product['brand']);
         $parentQ = $db->prepare("SELECT * FROM categories WHERE id =?");
         $parentQ->bind_param("s", $category);
         $parentQ->execute();
         $parent_fetched = $parentQ->get_result();
         $parent_results = $parent_fetched->fetch_assoc();


         $parent= ((isset($_POST['parent']) && $_POST['parent'] != '')? sanitize($_POST['parent']):$parent_results['parent']);
         $title=((isset($_POST['title']) && $_POST['title'] != '')? sanitize($_POST['title']):$product['title']);
         $price=((isset($_POST['price']) && $_POST['price'] != '')? sanitize($_POST['price']):$product['price']);
         $list_price=((isset($_POST['list_price']) )? sanitize($_POST['list_price']):$product['list_price']);
         $description=((isset($_POST['description']))? sanitize($_POST['description']):$product['description']);
         $sizes=((isset($_POST['sizes']) && $_POST['sizes'] != '')? sanitize($_POST['sizes']):$product['sizes']);
         $sizes = rtrim($sizes,',');
         $saved_image =(($product['image'] != '')?$product['image']:'');
         $dbpath=$saved_image;
         $latitude = ((isset($_POST['latitude']) && !empty($_POST['latitude']))? sanitize($_POST['latitude']):'');
         $longitude = ((isset($_POST['longitude']) && !empty($_POST['longitude']))? sanitize($_POST['longitude']):'');
 }

}

// sizes array
   if (!empty($sizes)) {
     $sizeString = sanitize($sizes);
     $sizeString = rtrim($sizeString,',');
     $sizesArray = explode(',', $sizeString);
     $sArray = array();
     $qArray = array();
     $tArray = array();
     foreach ($sizesArray as $ss) {
      $s = explode(':', $ss);
      $sArray[] = $s[0];
      $qArray[] = $s[1];
      $tArray[] = $s[2];
     }
   }else { $sizesArray = array();}

// add new prodcut to database function
  if ($_POST) {
    // $title = sanitize($_POST['title']);
    // $brand = sanitize($_POST['brand']);
    // $categories = sanitize($_POST['child']);
    // $price = sanitize($_POST['price']);
    // $list_price = sanitize($_POST['list_price']);
    // $sizes = sanitize($_POST['sizes']);
    // $description = sanitize($_POST['description']);
    $errors = array();
    $required = array('title', 'brand', 'price', 'parent', 'child', 'sizes');
    $allowed = array('png','jpg','jpeg','gif','jfif');
    // $photoName = array();
    // temporary location
    $tmpLoc = array();
    $uploadPath = array();
    foreach ($required as $field) {
      if ($_POST[$field] == '') {
          $errors[] = 'All fields with Astrick(*) are required.';
          break;
      }
    }


    // var_dump($_FILES['photo']);
    $photoCount = count($_FILES['photo']['name']); echo $photoCount;
    if ($photoCount > 0)  {
      for ($i=0; $i<$photoCount; $i++) {
        echo $i;
    //   // change this code to add product without image
    //   // if ($_FILES['photo']['name'] != '') {
    //   //   // code...
    //   // }
    //   $photo = $_FILES['photo'];
      $name = $_FILES['photo']['name'][$i];
      $nameArray = explode('.', $name);
      $fileName = $nameArray[0];
      $fileExt = $nameArray[1];
      $mime = explode('/', $_FILES['photo']['type'][$i]);
      $mimeType = $mime[0];
      $mimeExt = $mime[1];
      $tmpLoc[] = $_FILES['photo']['tmp_name'][$i];
      $fileSize = $_FILES['photo']['size'][$i];
      $uploadName = md5(microtime()).'.'.$fileExt;
     $uploadPath[] = BASEURL.'images/products/'.$uploadName;
     if ($i != 0) {
       $dbpath .= ',';
     }
      $dbpath .= '/images/products/'.$uploadName;
      if ($mimeType != 'image') {
        $errors[] = 'The product photo file must be an image.';
      }
      if (!in_array($fileExt, $allowed)) {
        $errors [] = 'The product photo file extension must be a png, jfif, jpeg, jpg or gif.';
      }
      if ($fileSize > 15000000) {
        $errors[] = 'The file size must be under 15mb';
      }
      if ($fileExt != $mimeExt && ($mimeExt == 'jpeg' && $fileExt != 'jpg' && $fileExt != 'jfif')) {
        $errors[] = 'File extension does not match the file.';
      }
     }
    }


    if (!empty($errors)) {
      echo display_errors($errors);
    }else{
      if ($photoCount > 0) {
        // Upload file and insert into database
        for ($i=0; $i < $photoCount; $i++) {
             move_uploaded_file($tmpLoc[$i], $uploadPath[$i]);
        }
      }
      // if (!empty($_FILES)) {
      //    move_uploaded_file($tmpLoc, $uploadPath);
      // }
      $user = $user_data['email'];
      $insertSql = $db-> prepare("INSERT INTO products (`title`,`price`,`list_price`,`brand`,`categories`,`sizes`,`image` , `description`, `user`, `location_lat`, `location_long`)
      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
      $insertSql->bind_param("siissssssss", $title, $price,$list_price,$brand,$category,$sizes,$dbpath,$description, $user, $latitude, $longitude);

      if (isset($_GET['edit'])) {
        $insertSql = $db->prepare("UPDATE products SET title= ?, price= ?, list_price= ?, brand= ?
           ,categories= ?, sizes= ?, image= ?, description= ?, user =?, location_lat =?, location_long=? WHERE id= ?");
        $insertSql->bind_param("siissssssssi", $title, $price,$list_price,$brand,$category,$sizes,$dbpath,$description, $user, $latitude, $longitude, $edit_id);
      }
      $insertSql->execute();
      // $insertSql->close();
      // $db->query($insertSql);
      // header('Location: products.php');
      if (isset($_GET['edit'])) {
        // code...
          header('Location: products.php?edit='.$edit_id);
      }else {
          header('Location: products.php');
      }


    }
  }
  ?>
<!-- //process the html for adding product -->

<h2 class="text-center"> <?=((isset($_GET['edit']))?'Edit':'Add a New');?> House</h2> <hr>
<form class="" action="products.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1');?>" method="post"  enctype="multipart/form-data">
 <div class="form-group col-md-3">
   <label for="title">House Name*:</label>
   <input type="text" name="title" class="form-control" id="title" value="<?=$title; ?>">
 </div>
 <div class="form-group col-md-3">
   <label for="brand">House Type*:</label>
   <select class="form-control" name="brand" id="brand">
     <option value="" <?=(($brand =='')?' selected':'');?>></option>
     <?php while($b = mysqli_fetch_assoc($brandQuery)): ?>
       <option value="<?=$b['id']; ?>" <?=(($brand == $b['id'])?' selected':''); ?>><?php echo $b['brand']; ?> </option>
     <?php endwhile; ?>
   </select>
 </div>

 <div class="form-group col-md-3">
   <label for="parent">Main Category/ County*:</label>
   <select class="form-control" id="parent" name="parent">
     <option value=""<?=(($parent == '')?' selected':'');?> ></option>
     <?php while($p = mysqli_fetch_assoc($parentQuery)): ?>
       <option value="<?=$p['id'];?>"<?=(($parent == $p['id'])? 'selected':'');?>><?php echo $p['category']; ?></option>
     <?php endwhile; ?>
   </select>
 </div>

 <div class="form-group col-md-3">
   <label for="child">Sub Category/location or localty  *:</label>
   <select id="child" name="child" class="form-control"  >


   </select>
   </div>

 <div class="form-group col-md-3">
   <label for="price">Our Rent per month*:</label>
   <input type="text" id="price" name="price" class="form-control"  value="<?=$price;?>">
 </div>

 <div class="form-group col-md-3">
   <label for="list_price">Nearby rent per Month:</label>
   <input type="text" id="list_price" name="list_price" class="form-control" value="<?=$list_price; ?>">
 </div>

 <div class="form-group col-md-3">
   <label > Number of units available*
     <!-- Quantity & Sizes*: -->
   </label>
   <button class="btn btn-primary form-control" onclick="jQuery('#sizesModal').modal('toggle');return false;">Quantity</button>
 </div>

   <div class="form-group col-md-3">
     <label for="sizes">Number of units preview

       <!-- Sizes & Qty Preview -->
     </label>
     <input type="text" class="form-control"  name="sizes" id="sizes"  value="<?=$sizes;?>" readonly>
   </div>


   <label for="" class="text-center" style="align:center; margin-top: 10px;">Images:</label><br>

 <div class="form-group col-md-6" style="border:1px solid #3ea1de;  padding: 5px;border-radius:5px;">

   <?php if ($saved_image != ''):?>
     <?php
     $imgIncr = 1;
     $images = explode(',' , $saved_image); ?>
     <?php foreach ($images as $image): ?>
     <div class="saved-image col-md-4">
        <img src ="<?=$image;?>" alt="saved image"/> <br>
     <a href="products.php?delete_image=1&edit=<?=$edit_id;?>&imgIncr=<?=$imgIncr;?>" class="text-danger">Delete Image</a>
     </div>
     <?php $imgIncr++;
   endforeach;
      ?>
   <?php else:?>
   <label for="photo">photos*:</label>
   <input type="file" id="photo" name="photo[]" class="form-control" multiple >
   <?php endif;?>
 </div>


 <div class="form-group col-md-6">
   <label for="description">Description:</label>
   <textarea id="description" name="description" class="form-control" value="<?=((isset($_POST['description']))?sanitize($_POST['description']):''); ?>" rows="6"><?=$description;?></textarea>
 </div>

 <div  class="myForm" >
   <input type="hidden" name="latitude" value="">
   <input type="hidden" name="longitude" value="">

 </div>

 <div class="form-group pull-right">
  <input type="submit" class="  btn btn-success " name="" value="<?=((isset($_GET['edit']))?'Edit':'Add');?> house">
  <a href="products.php" class="btn btn-danger">Cancel</a>

 </div>
 <div class="clearfix">
 </div>


      </form>

<!-- Modal -->
<div class="modal fade" id="sizesModal" tabindex="-1" role="dialog" aria-labelledby="sizesModalLabel">
 <div class="modal-dialog modal-lg" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
       <h4 class="modal-title" id="sizesModalLabel">Size & Quantity</h4>
     </div>
     <div class="modal-body">
       <div class="container-fluid">
         <?php for($i=1; $i<=12; $i++): ?>
         <div class="form-group col-md-2">
           <label for="size<?=$i;?>">Size:</label>
           <input type="text" name="size<?=$i;?>" id="size<?=$i;?>" value="<?=((!empty($sArray[$i-1]))?$sArray[$i-1]:'');?>" class="form-control" >
           </div>

       <div class="form-group col-md-2">
         <label for="qty<?=$i;?>">Quantity:</label>
         <input type="number" name="qty<?=$i;?>" id="qty<?=$i;?>" value="<?=((!empty($qArray[$i-1]))?$qArray[$i-1]:'');?>" class="form-control" min="0">
         </div>

         <div class="form-group col-md-2">
           <label for="threshold<?=$i;?>">Threshold:</label>
           <input type="number" name="threshold<?=$i;?>" id="threshold<?=$i;?>" value="<?=((!empty($tArray[$i-1]))?$tArray[$i-1]:'');?>" class="form-control" min="0">
           </div>

       <?php endfor; ?>
       </div>

     </div>
     <div class="modal-footer">
       <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
       <button type="button" class="btn btn-primary" onclick="updateSizes();jQuery('#sizesModal').modal('toggle');return false;">Save changes</button>
     </div>
   </div>
 </div>
</div>

<?php }

else {
  if (has_permission('admin')) {
    // code...
    $del__=0;
    $user = $user_data['email'];
  $sql =$db->prepare("SELECT * FROM products WHERE deleted = ?  ");
  $sql->bind_param("i", $del__);
  $sql->execute();
  $productResults = $sql->get_result();
}else {
  // code...
  $del__=0;
  $user = $user_data['email'];
$sql =$db->prepare("SELECT * FROM products WHERE deleted = ? AND user =? ");
$sql->bind_param("is", $del__, $user);
$sql->execute();
$productResults = $sql->get_result();
}


if (isset($_GET['featured'])) //change to feature
{
  $id = (int)$_GET['id'];
  $featured = (int)$_GET['featured'];
  $featuredSql = $db->prepare("UPDATE products SET featured = ? WHERE id = ?");
  $featuredSql->bind_param("ii", $featured, $id);
  $featuredSql->execute();
  // $featuredSql->close();
  // $db->query($featuredSql);
  header('Location: products.php');
}

?>

<h2 class="text-center">Houses</h2><span style="font-weight:bold;"> <hr> </span>
<a href="products.php?add" class="btn btn-warning pull-right" style="position:sticky; top:70px;"
 id="add-product-btn">Add House</a><div class="clearfix"></div>
<hr>
<div class="container table-responsive py-2">


<table cellspacing = 0 cellpadding=""  class="table  table-hover" style="border-collapse: separate; border-spacing:0 20px;">
 <thead class="table_head" >
   <th id="th" class="text-center">Edit</th>
   <th id="th" class="text-center">Product</th>
   <th id="th" class="text-center">Image</th>
   <th id="th" class="text-center">Price</th>
   <th id="th" class="text-center">Category</th>
   <th id="th" class="text-center">Featured</th>
   <!-- <th>Sold</th> -->
   <th id="th" class="text-center">Delete</th>

 </thead>

 <tbody>
   <?php while ($product = mysqli_fetch_assoc($productResults)) :
     $childID = $product['categories'];
     $catSql =$db->prepare("SELECT * FROM categories WHERE id = ?");
     $catSql->bind_param("i", $childID);
     $catSql->execute();
     $result = $catSql->get_result();
     $child = $result->fetch_assoc();
     $parentID = $child['parent'];
     $pSql = $db->prepare("SELECT * FROM categories WHERE id = ?");
     $pSql->bind_param("i", $parentID);
     $pSql->execute();
     $presult = $pSql->get_result();
     $parent = $presult->fetch_assoc();
     $category = $parent['category'].'~'.$child['category'];
     ?>


 <tr style="border-spacing:0 20px; border-collapse: separate; border-spacing:0 20px;">
   <td id="td" class=" text-center">
   <a href="products.php?edit=<?php echo $product['id']; ?>" class="btn btn-xs btn-primary"> <span class="text-center glyphicon glyphicon-edit"></span> </a>
   </td>
   <td id="td" class="text-center"><?php echo $product['title']; ?></td>

   <?php $photos = explode(',', $product['image']);
   ?>
   <td id="td"class="text-center">
      <img  style="width:50px; height:auto; border-radius:50%;"
       src="<?php echo $photos[0]; ?>" alt=""> </td>
   <td id="td"class="text-center"><?php echo money($product['price']); ?></td>
   <td id="td"class="text-center"><?php echo $category; ?></td>
   <td id="td" class="text-center"> <a href="products.php?featured=<?=(($product['featured']==0)?'1':'0');?> & id=<?=$product['id'];?>" class="">
      <span <?=(($product['featured'] == 1)?
      '<label class="switch">
       <input type="checkbox" checked>
      <span class="slider round"></span>
      </label>':'<label class="switch">
       <input type="checkbox" >
      <span class="slider round"></span>
      </label>');?>></span> </a>
    &nbsp <?= (($product['featured'] == 1)?'Featured ':'');?>

    <!-- <label class="switch">
     <input type="checkbox" checked>
    <span class="slider round"></span>
    </label> -->
    </td>
   <!-- <td>0</td> -->
   <td id="td" class="text-center">
       <a href="products.php?delete=<?php echo $product['id'];?>"
         class="btn btn-xs btn-danger">Delete
     <!-- <span class="
     glyphicon glyphicon-remove
     "
     ></span> -->
    </a>
</td>

 </tr>
<?php endwhile; ?>
 </tbody>
</table>
</div>

<?php } include 'includes/footer.php'; ?>

 <script>
   jQuery('document').ready(function(){
     get_child_options('<?=$category;?>');
   });
 </script>



 <script type="text/javascript">

  window.onload = getLocation();

 function getLocation(){
   if (navigator.geolocation) {
     const options = {
     enableHighAccuracy: true,
     timeout: 10000,
     maximumAge: 0
   };
     navigator.geolocation.getCurrentPosition(showPosition, showError, options);
   }
   else {
    x.innerHTML = "Geolocation is not supported by this browser.";
    }
  }



 function showPosition(position){
   document.querySelector('.myForm input[name = "latitude"]').value = position.coords.latitude;
   document.querySelector('.myForm input[name = "longitude"]').value = position.coords.longitude;

 }

 function showError(error){
   switch(error.code){
     case error.PERMISSION_DENIED:
     alert("You must allow the Request for location to fill list your property. Make sure you are within the vicinity of the property to get the exact location. Thank you.");
     location.reload();
     break;
   }
 }

//  const options = {
//   enableHighAccuracy: true,
//   timeout: 5000,
//   maximumAge: 0
// };

 </script>
