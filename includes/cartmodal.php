<?php
require_once '../core/init.php';
include '../includes/head.php';
 ?>








<div class="modal fade details-1" id="cart-modal" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
   <div class="modal-content">
    <div class="modal-header">
      <button class="close" type="button" onclick="closeModal()" aria-label="Close" >
        <span aria-hidden="true">&times;</span>
      </button>
      <h3 class="modal-title text-center" id="modal-Title"> Shopping Cart </h3>

    </div>
    <div class="modal-body">
      <div class="container-fluid">
        <div class="row">

          <?php if(empty($cart_id)): ?>
            <p>Your shopping cart is empty!</p>

          <?php else:
            $cartQ = $db->query("SELECT FROM cart WHERE id = '($cart_id)'");
            $results = mysqli_fetch_assoc($cartQ);
            $items = json_decode($results['items'], true);
            $i = 1;
            $sub_total = 0;

             ?>

             <div id="cart_modal">
               <table class="table table-condensed">
                 <thead>
                   <th>No. of items</th>
                   <th>Product Name</th>
                   <th>Sub Total</th>
                 </thead>

              <tbody>
                <?php foreach($items as $item):
                  $productQ = $db->query("SELECT * FROM products WHERE id = '{$item['id']}'");
                  $product = mysqli_fetch_assoc($productQ);
                  ?>

                  <tr>
                    <td> <?=$item['quantity'];?> </td>
                    <td><?= substr($product['title'], 0.15);?> </td>
                    <td><?=money($item['quantity'] * $product['price']);?></td>
                  </tr>

                  <?php
                    $sub_total += ($item['quantity'] * $product['price']);
                  endforeach;?>
                  <tr>
                    <td></td>
                    <br>
                    <td>Sub Total - Tax</td>
                    <td><?=money($sub_total)?></td>
                  </tr>

              </tbody>
              <!-- <a href="cart.php" class="btn btn-xs btn-warning">View Cart</a>
              <div class="clearfix"> </div> -->
            <?php endif; ?>
          </div>




               </table>

             </div>




            <!-- <p class="text-success" style="font-size:20px;">Price: Ksh <?php echo $product['price']; ?> </p> -->


          </div>
           </div>
        </div>
      </div>

    <div class="modal-footer">
      <!-- <p class="text-success" style="font-size:20px;">Price per unit: Ksh <?php echo $product['price']; ?> </p> -->

      <button class="btn btn-default" onclick="closeModal()">Close</button>
      <button class="btn btn-warning" onclick="add_to_cart(); return false;"> <span class="glyphicon glyphicon-shopping-cart"></span> Add To Cart </button>
    </div>

    <script>

      jQuery('#size').change(function(){
        var available = jQuery('#size option:selected').data("available");
        jQuery('#available').val(available);
      });

      function closeModal() {
      jQuery('#details-modal').modal('hide');
      setTimeout(function(){
        jQuery('#details-modal').remove();
        jQuery('.modal-backdrop').remove();
      }, 500);
      }
    </script>
