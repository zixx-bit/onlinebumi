


<div class="sticky-sidebar " style=" border-radius: 5px;
box-shadow: 0 2px 20px #333;
background-color:#ebfae3;
cursor: pointer;
position:sticky;
position: -webkit-sticky;
top:20px;
padding-bottom: 5px;
padding-right: 5px;
z-index:102;">



<h3 class="text-center">Shopping Cart</h3>
<div class="" >
  <?php  if (empty($cart_id)): ?>
    <p>Your shopping cart is empty!</p>

  <?php else:
$cartQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
$results = mysqli_fetch_assoc($cartQ);
$items = json_decode($results['items'], true);
$i = 1;

$sub_total = 0;
  ?>
 <div class="cart_style" id="cart_widget" >

   <table class="table table-condensed" id="">
     <thead>
       <th>No. of Items</th>
       <th>Product Name</th>
       <th >Sub Total </th>
     </thead>

    <tbody>
      <?php foreach ($items as $item):
        $productQ = $db->query("SELECT * FROM products WHERE id = '{$item['id']}'");
        $product = mysqli_fetch_assoc($productQ);
        ?>

        <tr>
          <td class=""> <?=$item['quantity'];?> </td>
          <td><?=substr($product['title'], 0.15);?></td>
          <td><?=money($item['quantity'] * $product['price']);?></td>
        </tr>

      <?php

      $sub_total += ($item['quantity'] * $product['price']);
    endforeach; ?>

     <tr class="bg-success">
       <td></td>
         <br>
       <td style="font-weight:bold;">Sub Total - Tax </td>
       <td style="font-weight:bold;"><?=money($sub_total)?></td>
     </tr>
    </tbody>
    </table>
     <a href="cart.php" class="btn btn-xs btn-warning pull-right">View cart</a>
     <div class="clearfix">    </div>

     </div>

  <?php endif;?>
  </div>
</div><hr>
