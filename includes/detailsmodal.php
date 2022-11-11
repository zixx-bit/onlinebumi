<?php
require_once '../core/init.php';
// include 'head.php';
$id = $_POST['id'];
$id = (int)$id;
$sql = "SELECT * FROM products WHERE id= '$id'";
$result = $db->query($sql);
$product = mysqli_fetch_assoc($result);
$brand_id = $product['brand'];
$email_id = $product['email'];
$sql2 = "SELECT brand FROM brand WHERE id = '$brand_id'";
$brand_query = $db->query($sql2);
$brand = mysqli_fetch_assoc($brand_query);
$sizestring = $product['sizes'];
$size_array = explode(',', $sizestring);
 ?>

<!-- details modal -->
<?php  ob_start(); ?>
<div class="modal fade details-1" id="details-modal" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
   <div class="modal-content">
    <div class="modal-header">
      <button class="close" type="button" onclick="closeModal()" aria-label="Close" >
        <span aria-hidden="true">&times;</span>
      </button>
      <h3 class="modal-title text-center" id="modal-Title"> <?php echo $product['title']; ?> </h3>
    </div>
    <div class="modal-body">
      <div class="container-fluid">
        <div class="row">

          <span id="modal_errors" class="bg-danger"></span>

          <div class="col-sm-6 "style=" border:1px solid #3ea1de;  padding: 5px;border-radius:5px;">
            <h5 style="font-weight:bold;" class=""><span style="">Images:</span></h5>


          <div class="py-2 fotorama" data-allowfullscreen="native"
           data-transition="slide" data-clicktransition="slide" data-nav="thumbs" data-thumbwidth="50"
            data-thumbheight="50" data-transitionduration="1700" data-fit="scaledown" data-thumbborderwidth="2"
            data-thumbborderradius="5px" data-duration = "2000" data-margin="">
            <?php $photos = explode(',', $product['image']);
            foreach ($photos as $photo): ?>

              <img style="border-radius:10px;" src="<?php echo $photo; ?>"
              alt="<?php echo $product['title']; ?>"
              class="details img-responsive">
                <?php endforeach; ?>
           </div>
          </div>

           <div  class="col-sm-6 py-1" >
               <h5 style="font-weight:bold;">Location:</h5>
                <!-- <div id="loader" class="text-center"></div> -->
             <div  class=" py-1 my-1" >
               <iframe  id="maps" src="https://www.google.com/maps?q=<?php echo $product['location_lat']; ?>,
                  <?php echo $product['location_long']; ?> &h1=es;z=14&output=embed" style="width:100%; height: 250px; border-radius: 5px;
                  object-fit: cover;"></iframe>

             </div>
           </div><br>
           <hr>

           <div class="">


           <h4 style="font-weight:bold;" class="text-center text-info"><span style="border-bottom:1px solid #000;">Details</span></h4><br>
            </div>
          <div class="col-sm-6 ">

            <p class="" style=""><strong>Rent:  <span class="text-danger">Ksh <?php echo $product['price']; ?></span> </strong></p><hr>
            <p> <strong>House Type:</strong> <?php echo $brand['brand']; ?> </p><hr>

            <p > <strong style="border-bottom:1px solid #000;">Description:</strong> </p>
            <p><?= $product['description']; ?></p>
            <!-- <hr> -->

              </div>

            <div class="col-md-6">
            <form action="add_cart.php" method="post" id="add_product_form">
              <!-- cart calls -->
              <input type="hidden" name="product_id"  value="<?=$id;?>">
              <input type="hidden" name="email"  value="<?=$email;?>">
              <input type="hidden" name="available" id="available" value="">

              <div class="form-group">
                <div class="col-xs-4">
                  <label for="quantity"> <strong>If you are booking select number of units :</strong></label>
                  <input type="number" class="form-control" id="quantity" name="quantity" min="0">
                </div>
                <div class="col-xs-6"> &nbsp; </div>
               </div>

              <div class="form-group">
                 <div class="col-xs-8">
                <label for="size"><strong>Available units:</strong></label>
                <select  name="size" id="size" class="form-control">
                  <option value=""></option>
                  <?php foreach($size_array as $string) {
                    $string_array = explode(':', $string);
                    $size = $string_array[0];
                    $available = $string_array[1];
                    if ($available >0) {

                    echo '<option value="'.$size.'" data-available="'.$available.'">'.$size.' ('.$available.' Available)</option>';
                  }
                  } ?>
                </select>
              </div>
            </div>
            </form>
     </div><br>

     <div class="my-2 d-grid gap-2">
     <button class="btn btn-warning" id="book-btn" onclick="add_to_cart(); return false;" style=""> <span class="glyphicon glyphicon-shopping-cart"></span>Book </button>
     or
     <button class="btn btn-default clearfix" onclick="closeModal()">Close</button>

     </div>


          </div>

          </div>
        </div>
      </div>

    <!-- <div class="modal-footer">
      <p class="text-success" style="font-size:20px;">Price per unit: Ksh <?php echo $product['price']; ?> </p>
      <button class="btn btn-default clearfix" onclick="closeModal()">Close</button>
      <button class="btn btn-warning" onclick="add_to_cart(); return false;"> <span class="glyphicon glyphicon-shopping-cart"></span> Add To Cart </button>
      <button id="loading" type="button" class="btn btn-sm btn-success" onclick="cartmodal(<?php echo $product['id']; ?>)">Buy Now</button>
    </div> -->
  </div>
  </div>
  <script>

    jQuery('#size').change(function(){
      var available = jQuery('#size option:selected').data("available");
      jQuery('#available').val(available);
    });



    //
    // $(function(){
    //   $('.fotorama').fotorama({
    //
    //     // 'loop':true, 'autoplay':true,
    //     spinner: {
    //     lines: 13,
    //     color: 'rgba(0, 0, 0, .75)'
    //   }
    //   });

    $(function(){
      $('.fotorama').fotorama({
        'loop':true, 'autoplay':true,
        spinner: {
          lines: 13,
          color: 'rgba(0, 0, 0, .75)'
        }
      });
    });





    function closeModal() {
    jQuery('#details-modal').modal('hide');
    setTimeout(function(){
      jQuery('#details-modal').remove();
      jQuery('.modal-backdrop').remove();
    }, 500);
  };

  document.onreadystatechange = function() {
           if (document.readyState !== "complete") {
               document.getElementById("#maps").style.visibility = "hidden";
               document.getElementById("#loader").style.visibility = "visible";
           } else {
               document.getElementById("#loader").style.display = "none";
               document.getElementById("#maps").style.visibility = "visible";
           }
       };


    </script>

    <script src="https://maps.google.com/maps/api/js?sensor=false">
  </script>


<?php  echo ob_get_clean(); ?>
