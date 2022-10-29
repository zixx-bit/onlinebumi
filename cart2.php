<?php
    require_once 'core/init.php';
    include 'includes/head.php';
    include 'includes/headerpartial.php';
    // include 'includes/navigation.php';
    // include 'mpesaprocessor.php';

    // $mpesaPhone ='';
    // $mpesaPhone = echo "$_POST['mpesaPhone']";

      $cart_id = '';
    if ($cart_id != '') {
      $cartQ = $db->query("SELECT  * FROM cart where id = '{$cart_id}'");
      $result = mysqli_fetch_assoc($cartQ);
      $items = json_decode($result['items'], true);
      $i = 1;
      $sub_total = 0;
      $item_count = 0;

    }




    ?>



<div class="col-md-12">
<td class="text-center" id="cart-text-design"></td>

<div class="row">

  <h2 class="text-center">My Shopping Cart</h2><hr>


  <?php if ($cart_id === ''): ?>
    <div class="bg-danger">
      <p class="text-center text-danger">Your shopping cart is empty</p>

    </div>
    <div class="container text-center">
      <a href="index.php" class="btn btn-primary">Exit</a>

    </div>
  <?php else: ?>
    <table class="table table-dark table-bordered table-condensed table-stripped ">
      <thead> <th class="text-center">Item</th> <th class="text-center">Image</th>
         <th class="text-center">Unit Price</th> <th class="text-center">Quantity</th>
          <th class="text-center">Size</th> <th class="text-center">Sub Total</th>
      </thead>
      <tbody>
        <?php
          foreach($items as $item) {
            $product_id = $item['id'];
            $productQ = $db->query("SELECT * FROM products WHERE id = '{$product_id}'");
            $product  = mysqli_fetch_assoc($productQ);
            $sArray = explode(',', $product['sizes']);
            foreach ($sArray as $sizeSring){
              $s = explode(':', $sizeSring);
              if ($s[0] == $item['size']) {
                $available = $s[1];
              }
            }
            ?>

            <tr>
              <!-- <td><?=$i;?></td> -->

              <td class="text-center "><?=$product['title'];?></td>
              <td><img class="" id="img-thumb-2" src=" <?=$product['image'];?>"></td>

              <td class="text-center" id="cart-text-design"><?=money($product['price']);?></td>

              <td class="text-center" id="cart-text-design">
                <button class="btn btn-xs btn-default" onclick="update_cart('removeone', '<?=$product['id']?>', '<?=$item['size']?>');">-</button>
                <?=$item['quantity'];?>
                <?php if ($item['quantity'] < $available):?>
                <button class="btn btn-xs btn-success" onclick="update_cart('addone', '<?=$product['id']?>', '<?=$item['size']?>');">+</button>
              <?php else:?>
                <span class="text-danger">Max</span>
              <?php endif; ?>
              </td>
              <td class="text-center"><?=$item['size'];?></td>
              <td class="text-center"><?=money($item['quantity'] * $product['price']);?></td>
            </tr>
        <?php
            $i++;
            $item_count += $item['quantity'];
            $sub_total += ($product['price'] * $item['quantity']);
          }
          $tax  = TAXRATE * $sub_total;

          $grand_total = $tax + $sub_total;

          if (isset($_GET['clearCart'])) {

            unset($items);
          }
          ?>

      </tbody>


    </table>


    <table  class="table table-condensed table-bordered text-right table-striped">
      <legend class="text-center">Totals</legend>
      <thead class="totals-table-header"><th>Total Items</th><th>Sub Total</th><th>Tax</th><th>Grand Total</th>
        <tbody>
          <tr>
            <td class="text-center" id="cart-text-design"><?=$item_count;?></td>
            <td class="text-center"><?=money($sub_total);?></td>
            <td class="text-center"><?=money($tax);?></td>
            <td class="text-center text-success" style="font-weight:bolder;"><?=money($grand_total);?></td>
          </tr>
        </tbody>

      </thead>
    </table>
    <!-- check out buttonl -->

    <!-- <div class="text-center">
    <button type="button" class="btn btn-success  " data-toggle="modal" data-target="#checkoutModal">
    <span class="glyphicon glyphicon-credit-card "></span>  Mpesa
    </button>
    </div> -->

<div class="container">
  <div class="row">
    <div class="col-md-4">

    </div>




    <div class="col-md-4 pull-left">
        <a href="index.php" class="btn btn-primary">Exit</a>

    </div>

    <div class="col-md-4 pull-right">

    <span>Pay with</span>  <button type="button" class="btn btn-default" id="" name="" style="padding: 3px; border-radius: 5px;border:1px solid grey"
       data-toggle="modal" data-target="#checkoutModal">
             <img src="images/logo/mpesa.jfif" alt="Mpesa checkout" width = "auto" height = "35">

      </button>
      <!-- <a type="button" href="cart2.php" class="btn btn-secondary" id="" name="" style="padding: 3px; border-radius: 5px;border:1px solid grey">
        <img src="images/logo/mpesa.jfif" alt="Mpesa checkout" width = "auto" height = "35">
         </a> -->
    </div>

  </div>

</div>




<!-- Modal -->
<div class=  "modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel">
<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="checkoutModalLabel">Delivery Address</h4>
    </div>
    <div class="modal-body">
        <div class="row">
        <form action="thankyou.php" method="post">
          <span class="bg-danger" id="payment-errors"></span>

          <input type="hidden" name="tax" value="<?=$tax;?>">
          <input type="hidden" name="sub_total" value="<?=$sub_total;?>">
          <input type="hidden" name="grand_total" value="<?=$grand_total;?>">
          <input type="hidden" name="cart_id" value="<?=$cart_id;?>">
          <input type="hidden" name="description" value="<?=$item_count.' item'.(($item_count>1)?'s':''). ' from Online Soko.';?>">

          <div  id="step1" style="display:block;">
              <div class="form-group col-md-6">
                <label for="full_name">Full Name:</label>
                <input class="form-control" id="full_name" name="full_name" type="text" >
              </div>
              <div class="form-group col-md-6">
                <label for="email">Email:</label>
                <input class="form-control" id="email" name="email" type="email" >
              </div>
              <div class="form-group col-md-6">
                <label for="street">Street Address or name :</label>
                <input class="form-control" id="street" name="street" type="text"  >
              </div>
              <div class="form-group col-md-6">
                <label for="street2">Phone Number (M-pesa paying number):</label>
                <input class="form-control" id="street2" name="street2" type="text" >
              </div>
              <div class="form-group col-md-6">
                <label for="city">County:</label>
                <input class="form-control" id="city" name="city" type="text"  >
              </div>
              <div class="form-group col-md-6">
                <label for="state">Estate, Apartment, Suite, etc:</label>
                <input class="form-control" id="state" name="state" type="text" >
              </div>
              <div class="form-group col-md-6">
                <label for="zip_code">House no:</label>
                <input class="form-control" id="zip_code" name="zip_code" type="text" >
              </div>
              <div class="form-group col-md-6">
                <label for="country">Country:</label>
                <input class="form-control" id="country" name="country" type="text" >
              </div>
           </div>

           <!-- credit card modal -->
          <div  id="step2" style="display:none;">

            <div class="form-group col-md-5">
              <label for="grand_total" id="grand_total" name="grand_total" class="text-success"> Pay  <?=money($grand_total);?></label>
            </div>

              <div class="form-group col-md-5">


              </div>


          </div>
          <?php
              // $mpesaPhone .='<span id="phoneValue"></span>';
           ?>

      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      <button type="button" class="btn btn-primary" onclick="check_address();" id="next_button">Next >></button>
      <button type="button" class="btn btn-primary" onclick="back_address();" id="back_button" style="display:none;"> << Back </button>
      <button type="submit" class="btn btn-info" id="check_out_button" name="check_out_button" style="display:none;"> Next >></button>

      </form>
    </div>
  </div>
</div>
</div>
  <?php endif; ?>
</div>
</div>

<?php


 if(isset($_POST['submit'])){
    $from = "eddmichira@gmail.com"; // this is the sender's Email address
     $to =  $_POST['email']; // this is reciever Email address
     $first_name = $_POST['full_name'];

     $subject = "Order Deatils";
     $subject2 = "Copy of your form oder details";
     $message = "Hello ".$full_name . " the oder details are:" . "\n\n" . $_POST[''];
     $message2 = "Here is a copy of your message " . $first_name . "\n\n" . $_POST[''];

     $headers = "From:" . $from;
     $headers2 = "From:" . $to;
     mail($to,$subject,$message,$headers);
     mail($from,$subject2,$message2,$headers2); // sends a copy of the message to the sender
     echo "Mail Sent. Thank you " . $first_name . ", we will contact you shortly.";
     // You can also use header('Location: thank_you.php'); to redirect to another page.
     }


 ?>

<script>

  function back_address(){
    jQuery('#payment-errors').html("");
    jQuery('#step1').css("display","block");
    jQuery('#step2').css("display","none");
    jQuery('#next_button').css("display","inline-block");
    jQuery('#back_button').css("display","none");
    jQuery('#check_out_button').css("display","none");
    jQuery('#mpesa_button').css("display","none");
    jQuery('#checkoutModalLabel').html("Delivery Address");
  }

 function check_address(){
   var data = {
     'full_name' : jQuery('#full_name').val(),
     'email' : jQuery('#email').val(),
     'street' : jQuery('#street').val(),
     'street2' : jQuery ('#street2').val(),
     'city' : jQuery('#city').val(),
     'state' : jQuery('#state').val(),
     'zip_code' : jQuery('#zip_code').val(),
     'country' : jQuery('#country').val(),
     'grand_total' : jQuery('#grand_total').val(),
     'mpesaPhone' : jQuery('#mpesaPhone').val(),

   };

   jQuery.ajax({
     url : '/online store/admin/parsers/check_address.php',
     method : 'POST',
     data : data,

    success : function(me){
      if(me != 1) {
        jQuery('#payment-errors').html(me);
      }
        if (me == true) {
        jQuery('#payment-errors').html("");
        jQuery('#step1').css("display","none");
        jQuery('#step2').css("display","block");
        jQuery('#next_button').css("display","none");
        jQuery('#back_button').css("display","inline-block");
        jQuery('#check_out_button').css("display","inline-block");
        jQuery('#mpesa_button').css("display","inline-block");

        jQuery('#checkoutModalLabel').html("Amount to pay");
    }

  },

    error : function (){
      alert("Something went wrong!");
    },

   });
 }
</script>


<script>
 function mpesaPass(){
    var data = jQuery('#mpesaPhone').val();
    if (data != '')
    {
      $.ajax({
        url:"/online store/mpsa/lipa.php",
        method:"post",
        data:data,
        // dataType:"text",

        success:function(data)
        {
          alert("data passed successfully!");
        }
      });

    }
    else {
      alert("something went wrong!");
    }

});

</script>


<?php include 'includes/footer.php'; ?>
