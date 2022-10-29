<?php
define('BASEURL', $_SERVER['DOCUMENT_ROOT'].'/online store/');
define('CART_COOKIE', 'Ed467ytgSrtH3p');
define('CART_COOKIE_EXPIRE', time() + (86400 * 30));
define('TAXRATE', 0.0);

define('CURRENCY', 'KES');
define('CHECKOUTMODE', 'TEST');

if (CHECKOUTMODE == 'TEST') {
  define('STRIPE_PRIVATE', 'sk_test_51B8Ts4DejSXizJyp5y95AIFcJuMnePgRUn0lms4uNDB2yXXYQfNKD0cVhDVRHEkv0tCGYEqJAV0zpXWbCr8O2B3R00Ji1iXtxp
');
  define('STRIPE_PUBLIC', 'pk_test_re8qMxlNRUaDYct8RutUGYiV');
}

if (CHECKOUTMODE == 'LIVE') {
  define('STRIPE_PRIVATE', '');
  define('STRIPE_PUBLIC', '');
}
