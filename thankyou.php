<?php

// error_reporting(0);
require_once 'core/init.php';
// set your secret key
// //
// \Stripe\Stripe::setApiKey(STRIPE_PRIVATE);
// // \Stripe\Stripe::setVerifySslCerts(false);
// // //
// if ($cart_id == '') {
// header("Location: cart2.php");
//   // code...
// }

//get the credit card details submitted by the form
// $token = $_POST['stripeToken'];
// get the rest of the post data
$full_name = sanitize($_POST['full_name']);
$email = sanitize($_POST['email']);
$street =  sanitize($_POST['street']);
$street2 = sanitize($_POST['street2']);
$city = sanitize($_POST['city']);
$state = sanitize($_POST['state']);
$zip_code = sanitize($_POST['zip_code']);
$country = sanitize($_POST['country']);
$tax  = sanitize($_POST['tax']);
$sub_total = sanitize($_POST['sub_total']);
$grand_total = sanitize($_POST['grand_total']);
$cart_id = sanitize($cart_id);
$description = sanitize($_POST['description']);
$charge_amount = number_format($grand_total, 2);
$metadata = array(
  "cart_id" => $cart_id,
  "tax"     => $tax,
  "sub_total" => $sub_total,
);

//create the change on Stripe servers. this will change users card

//
// try {
//
//
//   $charge = \Stripe\Charge::create(array(
//     "amount"        => $charge_amount, //amount in cents
//     "currency"      =>CURRENCY,
//     "source"        =>$token,
//     "description"   =>$description,
//     "receipt_email" => $email,
//     "metadata"      => $metadata
//   )
//   );

// adjust inventory
  $itemQ = $db->query("SELECT * FROM cart WHERE id ='{$cart_id}'");
  $iResults = mysqli_fetch_assoc($itemQ);
  $items = json_decode($iResults['items'], true);
  foreach ($items as $item) {
    $newSizes = array();
    $item_id = $item['id'];
    $productQ = $db->query("SELECT sizes FROM products WHERE id='$item_id'");
    $product = mysqli_fetch_assoc($productQ);
    $sizes = sizesToArray($product['sizes']);
    foreach ($sizes as $size) {
      if($size['size'] == $item['size']){
        $q = $size['quantity'] - $item['quantity'];
        $newSizes[] = array('size' => $size['size'], 'quantity' => $q);
      }else {
        $newSizes[] = array('size' =>$size['size'], 'quantity' => $size['quantity']);
      }
    }
    $sizeString = sizesToString($newSizes);
    $db->query("UPDATE products SET sizes = '{$sizeString}' WHERE id = '{$item_id}'");
  }

// update cart

  $db->query("UPDATE cart SET paid=1 WHERE id = '{$cart_id}'");
  $db->query("INSERT INTO transactions
    (charge_id, cart_id, full_name, email, street, street2, city, state, zip_code, country, sub_total, tax, grand_total, description, txn_type) VALUES
    ('', '$cart_id', '$full_name', '$email', '$street', '$street2', '$city', '$state', '$zip_code', '$country', '$sub_total', '$tax', '$grand_total', '$description', '')");

 $domain = ($_SERVER['HTTP_HOST'] != 'localhost')?'.'.$_SERVER['HTTP_HOST']:false;
 setcookie(CART_COOKIE, '',1,"/", $domain, false);
 include 'includes/head.php';
 // include 'includes/navigation.php';

 // include 'includes/headerpartial.php';
 ?>

    <h3 class="text-center text-success">M-PESA PAYMENT</h3>
    <div class="text-center">
      <p> Your mpesa will be deducted <strong><?=money($grand_total);?></strong>. if you confirm payment below
        </p>

        <p>Your oder will be delivered to the address below</p>
        <address class="">
          <?=$full_name;?><br>
          <?=$street;?><br>
          <?=(($street2 != '')? $street2. '<br>':'');?><br>
          <?=$city.' '. $state.' '. $zip_code;?> <br>
          <?=$country;?><br>
        </address>




    </div>

    <div class="text-center ">
      <a href="pay/mpsa_pay.php?phone=<?=$street2;?>&total=<?=$grand_total;?>'" class="btn btn-success" >Confirm Payment</a>
    </div>
