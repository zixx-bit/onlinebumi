  <?php
      require_once 'core/init.php';
      include 'includes/head.php';
      // include 'includes/navigation.php';
      // include 'mpesaprocessor.php';




        
      if ($cart_id != '') {
        $cartQ = $db->query("SELECT  * FROM cart where id = '{$cart_id}'");
        $result = mysqli_fetch_assoc($cartQ);
        $items = json_decode($result['items'], true);
        $i = 1;
        $sub_total = 0;
        $item_count = 0;

        unset($Items);



      }

      if (isset($_GET['clearCart'])) {
        unset($Item);
      }
    ?>
<div class="col-md-12">
  <td class="text-center" id="cart-text-design"></td>

  <div class="row">

    <h2 class="text-center">My Shopping Cart</h2><hr>


    <div class="checkout_type_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title text-info">Check out >></h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <!-- <span aria-hidden="true">&times;</span> -->
        </button>
      </div>
      <div class="modal-body">
        <p> <strong> Please choose check out mode.</strong> </p>

      </div>
      <div class="modal-footer">
        <div class="row">

          <!-- <button type="button" class="btn btn-success"></button> -->
          <div class="col-md-4" style="margin-bottom:7px;">
            <a type="button" href="index.php" class="btn btn-default" id="" name="">
               << <span class="glyphicon glyphicon-shopping-cart "></span> Continue Shopping</a>

          </div>
          <div class="col-md-2">
            <a href="cart.php"  class="btn btn-danger" id="clearCart"
             name="clearCart">Clear cart</a>


          </div>

          <div class="col-md-4" style="margin-bottom:7px;">
            <a type="button" href="cart2.php" class="btn btn-default" id="" name="" style="padding: 3px; border-radius: 5px;border:1px solid grey">
              <img src="images/logo/mpesa.jfif" alt="Mpesa checkout" width = "auto" height = "35">
               </a>

          </div>
          <div class="col-md-4" style="margin-right:;">
            <a type="button" href="cart3.php" class="btn btn-primary" id="card_checkout" name="">
              <span class="glyphicon glyphicon-credit-card "></span> Card checkout</a>

          </div>
        </div>




      </div>
    </div>
  </div>
</div>












    <?php if ($cart_id === ''): ?>
      <div class="bg-danger">
        <p class="text-center text-danger">Your shopping cart is empty</p>

      </div>
    <?php else: ?>
      <table class="table table-dark table-bordered table-condensed table-stripped ">
        <!-- <thead> <th class="text-center">Item</th> <th class="text-center">Image</th>
           <th class="text-center">Unit Price</th> <th class="text-center">Quantity</th> <th class="text-center">Size</th> <th class="text-center">Sub Total</th>
        </thead> -->
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

              <!-- <tr>

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
              </tr> -->
          <?php
              $i++;
              $item_count += $item['quantity'];
              $sub_total += ($product['price'] * $item['quantity']);
            }
            $tax  = TAXRATE * $sub_total;

            $grand_total = $tax + $sub_total;
            ?>

        </tbody>


      </table>


      <!-- <table  class="table table-condensed table-bordered text-right table-striped">
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
      </table> -->
      <!-- check out buttonl -->

      <!-- <div class="text-center">
      <button type="button" class="btn btn-success  " data-toggle="modal" data-target="#checkoutModal">
      <span class="glyphicon glyphicon-credit-card "></span>  Mpesa
      </button>
      </div> -->

<div class="text-center">
<!-- <button type="button" class="btn btn-info  pull-right " data-toggle="modal" data-target="#checkoutModal"> -->
<!-- <span class="glyphicon glyphicon-credit-card "></span>  check out -->
</button>
</div>
<!-- Modal -->
<div class=  "modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="checkoutModalLabel">Shipping Address</h4>
      </div>
      <div class="modal-body">
          <div class="row">
          <form action="thankyou.php" method="post" id="payment-form">
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
                  <input class="form-control" id="street" name="street" type="text" data-stripe="address_line1" >
                </div>
                <div class="form-group col-md-6">
                  <label for="street2">Phone Number:</label>
                  <input class="form-control" id="street2" name="street2" type="text" data-stripe="address_line2" >
                </div>
                <div class="form-group col-md-6">
                  <label for="city">County:</label>
                  <input class="form-control" id="city" name="city" type="text" data-stripe="address_city" >
                </div>
                <div class="form-group col-md-6">
                  <label for="state">Estate, Apartment, Suite, etc:</label>
                  <input class="form-control" id="state" name="state" type="text" data-stripe="address_state">
                </div>
                <div class="form-group col-md-6">
                  <label for="zip_code">House no:</label>
                  <input class="form-control" id="zip_code" name="zip_code" type="text" data-stripe="address_zip">
                </div>
                <div class="form-group col-md-6">
                  <label for="country">Country:</label>
                  <input class="form-control" id="country" name="country" type="text" data-stripe="address_country">
                </div>
             </div>

             <!-- credit card modal -->
            <div  id="step2" style="display:none;">

                <div class="form-group col-md-3">
                  <label for="name"> Name on Card:</label>
                  <input type="text" id="name" class="form-control" data-stripe="name">
                </div>
                <div class="form-group col-md-3">
                  <label for="number"> Card Number:</label>
                  <input type="text" id="number" class="form-control" data-stripe="number">
                </div>
                <div class="form-group col-md-2">
                  <label for="cvc"> CVC:</label>
                  <input type="text" id="cvc" class="form-control" data-stripe="cvc">
                </div>
                <div class="form-group col-md-2">
                  <label for="exp-month"> Expire Month:</label>
                  <select id="exp-month" class="form-control" data-stripe="exp_month">
                    <option value=""></option>
                    <?php for ($i=1; $i<13; $i++): ?>
                      <option value="<?=$i;?>"><?=$i;?></option>
                    <?php endfor; ?>
                  </select>
                </div>
                <div class="form-group col-md-2">
                  <label for="exp_year">Expire Year:</label>
                  <select type="text" id="name" class="form-control" data-stripe="exp_year">
                    <option value=""></option>
                    <?php $yr = date("Y");?>
                    <?php for ($i=0; $i<11 ; $i++):?>
                      <option value="<?=$yr+$i; ?>"> <?=$yr+$i;?></option>
                    <?php endfor; ?>
                  </select>
                </div>
            </div>

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="check_address();" id="next_button">Next >></button>
        <button type="button" class="btn btn-primary" onclick="back_address();" id="back_button" style="display:none;"> << Back </button>
        <button type="submit" class="btn btn-info" id="check_out_button" style="display:none;"> Check Out >></button>
        </form>
      </div>
    </div>
  </div>
</div>
    <?php endif; ?>
  </div>

</div>

<script >
$(document).ready ( function(){
 alert('ok');
 jQuery('.checkout_type_modal').html("");
});​
</script>

<script>

    function back_address(){
      jQuery('#payment-errors').html("");
      jQuery('#step1').css("display","block");
      jQuery('#step2').css("display","none");
      jQuery('#next_button').css("display","inline-block");
      jQuery('#back_button').css("display","none");
      jQuery('#check_out_button').css("display","none");
      jQuery('#checkoutModalLabel').html("Shipping Address");
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
          jQuery('#checkoutModalLabel').html("Enter Your Card Details");
      }

    },

      error : function (){
        alert("Something went wrong!");
      },

     });
   }


    Stripe.setPublishableKey('<?=STRIPE_PUBLIC; ?>');


    function stripeResponseHandler(status, response){
      var $form = $('#payment-form');

      if (response.error) {
        // show the errors on the form
        $form.find('#payment-errors').text(response.error.message);
        $form.find('button').prop('disabled', false);

      }else {
        // respons contains id and card, which contains additionl card details
        var token = response.id;
        // insert the token into the form so it gets submitted to the server
        $form.append($('<input type = "hidden" name = "stripeToken"/>'). val(token));
        // and submit
        $form.get(0).submit();
      }
    };

    jQuery(function($){
      $('#payment-form').submit(function(event){
        var $form = $(this);

        // disable the submit button to prevent repeated clicks
        $form.find('button').prop('disabled', true);
        Stripe.card.createToken($form, stripeResponseHandler);

        // prevent the form from submitting with default action
        return false;
      });
    });


</script>
<?php include 'includes/footer.php'; ?>
